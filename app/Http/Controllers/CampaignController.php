<?php

namespace App\Http\Controllers;

use App\Jobs\CampaignJob;
use App\Jobs\SendBulkMessageJob;
use App\Models\Campaign;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::where('user_id', Auth::id())->get();
        return view('admin.messages.campaign', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $devices = Device::where('user_id', Auth::id())->where('status','=','connected')->get(); 
        return view('admin.messages.send-campaign', compact('devices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contacts = Contact::count();
		if(!$contacts)
		{
			toast('Kirim pesan gagal, tidak ada kontak yang terdaftar', 'warning');
			return redirect()->back();
		}
        
        if(!$request->device_method) {
			toast('Device method harus di isi!', 'warning');
			return redirect()->back();
		}
		
		if($request->device_method == 'selected_device') {
			$this->validate($request,
			[
				'text' => 'required|min:8',
				'waKey' => 'required',
				'type' => 'required'
			],
			[
				'text.required' => 'Pesan tidak boleh dikosongkan!',
				'text.min' => 'Pesan minimal 8 karakter',
				'waKey.required' => 'Device ID harus di pilih terlebih dahulu!',
				'type.required' => 'Type harus di pilih terlebih dahulu!'
			]);
		}else{
			$this->validate($request,
			[
				'text' => 'required|min:8',
				'type' => 'required'
			],
			[
				'text.required' => 'Pesan tidak boleh dikosongkan!',
				'text.min' => 'Pesan minimal 8 karakter',
				'type.required' => 'Type harus di pilih terlebih dahulu!'
			]);
		}

        if($request['type'] == "Text") {
            $body = isset( $request->header) . $request->text . isset($request->footer);
            if($request->url_file)
            {
                toast('Anda tidak dapat mengirim file/dokumen, jika type nya text', 'warning');
                return redirect()->back();
            }
            
        } else if($request['type'] == "Image" ) {

                $file       = $request->url_file;
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $file->move(public_path().'/upload/file/image', $doc);
                $body = [

					'image'=>public_path().'/upload/file/'.$doc,
					'caption' => $request->text,
                    'footer' => $request->footer,
                    'header' => $request->header
				];

        } else if($request['type'] == "Video" ) {

                $file       = $request->url_file;
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $file->move(public_path().'/upload/file/video', $doc);
				$body = [

					'video'=>public_path().'/upload/file/'.$doc,
					'caption' => $request->text ,
                    'footer' => $request->footer,
                    'header' => $request->header

				];

        } else if($request['type'] == "PDF" ) {

                $file       = $request->file('url_file');
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $file->move(public_path().'/upload/file/document', $doc);
                $body = [
					'document'=> public_path().'/upload/file/'.$doc,
					'caption' => $request->text,
					'fileName' => $namaFile,
                    'footer' => $request->footer,
                    'header' => $request->header
				];
        }

        if(isset($doc) && isset($namaFile))
        {
            $document = $doc;
            $file_name = $namaFile;
        }else {
            $document = null;
            $file_name = null;
        }



        $getResponse = Http::withBody(
			http_build_query(['waKey' => $request->waKey]), 'application/x-www-form-urlencoded'
		)->send('GET', env('URL_WA_SERVER').'/connect');

        if($getResponse->status() == 500)
        {
            Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
            return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!']);
        }

		if($getResponse->status()!= 200)
		{
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			return response()->json(['message' => 'gagal mengirim pesan']);
		}
        

        if($request->device_method == 'autoswitch_device') {
			// Ambil perangkat yang statusnya "connected"
			$devices = Device::where('user_id', Auth::id())->where('status', '=', 'connected')->get();
			$totalDevices = count($devices); // Total perangkat yang tersedia
			$messageCount = 0; // Counter untuk pesan
			$deviceIndex = 0;  // Index untuk mengatur perangkat
			$maxMessage = 1;  // Maksimal 10 pesan per perangkat
		
			// Ambil kontak dalam chunk 100
			Contact::select('phone_number')->chunk(100, function($contacts) use ($body, $devices, &$messageCount, &$deviceIndex, $totalDevices, $maxMessage, $request) {
				foreach ($contacts as $index => $a) {
					// Ambil device saat ini berdasarkan deviceIndex
					$currentDevice = $devices[$deviceIndex]; 
					$request['waKey'] = $currentDevice->id; // Set device ID di request
		
					// Menghitung delay berdasarkan index pesan
					$delay = ($index + 1) * $request->second;
					$number = $a->phone_number . '@s.whatsapp.net';
		
					// Dispatch job untuk mengirim pesan ke nomor
					dispatch(new SendBulkMessageJob($number, $body, $request->all(), $a->phone_number))->delay(now()->addSeconds($delay));
		
					// Tingkatkan counter pesan
					$messageCount++;
		
					// Setelah 10 pesan, ganti ke perangkat berikutnya
					if ($messageCount >= $maxMessage) {
						// Reset counter pesan
						$messageCount = 0;
		
						// Ganti ke device berikutnya
						$deviceIndex = ($deviceIndex + 1) % $totalDevices; 
						// Jika sudah menggunakan perangkat terakhir, kembali ke perangkat pertama
					}
				}
			});
		} else if($request->device_method == 'selected_device')
		{
            Contact::select('phone_number')->chunk(100, function($contacts) use ($body, $request) {
                foreach ($contacts as $index => $a) {
                    $delay = ($index+1) * $request->second;
                    $number = $a->phone_number . '@s.whatsapp.net';
                    dispatch(new CampaignJob($number, $body, $request->all(), $a->phone_number))->delay(now()->addSeconds($delay));
                }
            });
        }

        Campaign::create([
            'receiver_type' => $request->receiver_type,
            'number' => 'all contact',
            'header' => $request->header,
            'text' => $request->text,
            'footer' => $request->footer,
            'status' => 1,
            'delay' => $request->second,
            'id_device' => $request->waKey,
            'type' => $request->type,
            'url_file' => $document,
            'user_id' => Auth::id()
        ]);

        toast('Campaign berhasil dibuat!','success');
        return redirect()->route('admin.campaign');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
