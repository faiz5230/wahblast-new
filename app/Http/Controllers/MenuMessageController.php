<?php

namespace App\Http\Controllers;

use App\Jobs\SendBulkMessageJob;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\Device;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MenuMessageController extends Controller
{
    public function index()
    {
        $devices = Device::where('user_id', Auth::id())->where('status','=','connected')->get(); 
        return view('admin.messages.send-message', compact('devices'));
    }

    public function sendChat(Request $request)
    {
		$this->validate($request,
        [
            'number' => 'required',
            'waKey' => 'required',
            'text' => 'required|min:8',
            'type' => 'required'
        ],
        [
            'number.required' => 'Nomor tidak boleh dikosongkan!',
            'number.numeric' => 'Nomor harus berisi angka!',
            'waKey.required' => 'Device ID harus di pilih terlebih dahulu!',
            'text.required' => 'Pesan tidak boleh dikosongkan!',
            'text.min' => 'Pesan minimal 8 karakter',
            'type.required' => 'Type harus di pilih terlebih dahulu!'
        ]);

		if($request->get('type') == "Text") {

				$body = $request->text;

				if($request->url_file)
				{
					toast('Anda tidak dapat mengirim file/dokumen, jika type nya text', 'warning');
					return redirect()->back();
				}

		} else if($request->get('type') == "Image" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$image      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $image);
				$body = [

					'image'=>public_path().'/upload/file/'.$image,
					'caption' => $request->text 
				];
	
		} else if($request->get('type') == "Video" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$video      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $video);
				$body = [

					'video'=>public_path().'/upload/file/'.$video,
					'caption' => $request->text 

				];


		} else if($request->get('type') == "PDF" ) {

				$file       = $request->file('url_file');
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$doc      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $doc);
				$body = [
					'document'=> public_path().'/upload/file/'.$doc,
					'caption' => $request->text,
					'fileName' => $namaFile
				];
		}

		$getResponse = Http::withBody(
			http_build_query(['waKey' => $request->waKey]), 'application/x-www-form-urlencoded'
		)->send('GET', env('URL_WA_SERVER').'/connect');

		if($getResponse->status() == 500)
		{
			toast('Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya','error');
			return redirect()->route('admin.history-messages');
		}

		if($getResponse->status() != 200)
		{
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			toast('koneksi anda terputus!','warning');
			return redirect()->route('admin.history-messages');
		}

		$numbers_in_arrays = explode( ',' , $request->input( 'number' ) );

		foreach($numbers_in_arrays as $a)
		{
			// $countLogChat = Chat::where('id_device', $request->waKey)->count();
			// $limitMessageDevice = Device::whereId($request->key)->count();
			// if($countLogChat > $limitMessageDevice)
			// {
			// 	toast('Pesan anda kami limit! karna hanya akun demo','error');
			// 	return redirect()->route('admin.history-messages');
			// }

			$number = $a . '@s.whatsapp.net';
			$response = Http::post(env('URL_WA_SERVER').'/send-message', [
				'id' => $number,
				'text' => $body
			]);
			
			if($response['status']){
				$status = 100;
			}else{
				$status = 0;
			}

			Chat::create([
				'id_device' => $request->waKey,
				'number' => $request->number,
				'from_name' => Device::find($request->waKey)->name,
				'text' => $request->text,
				'type' => $request->type,
				'status' => $status,
				'user_id' => Auth::id()
			]); 

			if(SystemSetting::getValue('setting_webhook')!=null) {
				$response = Http::post(SystemSetting::getValue('setting_webhook'), [
					'id' => $number,
					'text' => $body
				]);
			}
		}


		if($response['status'] == 1) {		

			toast('Pesan berhasil terkirim!','success');

		} elseif($response['status'] == 0) {

			toast('Pesan Gagal dikirim!','error');

		}

		return redirect()->route('admin.history-messages');
        
    }

    public function addChatByNumber($phone_number)
	{
		$getNumber = $phone_number;
        $devices = Device::where('user_id', Auth::id())->where('status','=','connected')->get(); 
		return view('admin.messages.send-message-by-number', compact('getNumber','devices'));
	}

    public function historyMessage(Request $request)
    {
        $chats = Chat::where('user_id', Auth::id())->latest()->get();
        return view('admin.messages.history-message', compact('chats', 'request'));
    }

    // public function scheduleMessage()
    // {
    //     return view('admin.messages.schedule-message');
    // }

    // public function addScheduleMessage()
    // {
    //     $devices = Device::where('status','=','connected')->get(); 
    //     return view('admin.messages.send-schedule-message', compact('devices'));
    // }

    // public function sendScheduleMessage(Request $request)
    // {
	// 	if(Auth::user()->status_account == 'demo')
    //     {
    //         toast('Akses dibatasi! status akun hanya demo','error');
    //         return redirect()->route('admin.schedule-message');
    //     }
    //    	dd($request->all());
    // }

    // public function campaign()
    // {
    //     return view('admin.messages.campaign');
    // }

    // public function addCampaign()
    // {    
    //     $devices = Device::where('status','=','connected')->get(); 
    //     return view('admin.messages.send-campaign', compact('devices'));
    // }

    // public function sendCampaign(Request $request)
    // {
    //     if(Auth::user()->status_account == 'demo')
    //     {
    //         toast('Akses dibatasi! status akun hanya demo','error');
    //         return redirect()->route('admin.campaign');
    //     }
	// 	dd($request->all());
    // }

    public function viewBulkMessage()
    {
        $devices = Device::where('user_id', Auth::id())->where('status','=','connected')->get(); 
        return view('admin.messages.send-bulk-message', compact('devices'));
    }

    public function sendBulkMessage(Request $request)
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

		$d = $request->all();
		if($request->get('type') == "Text") {

				$body = $request->text;
				if($request->url_file)
				{
					toast('Anda tidak dapat mengirim file/dokumen, jika type nya text', 'warning');
					return redirect()->back();
				}

		} else if($request->get('type') == "Image" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$image      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $image);
				$body = [

					'image'=>public_path().'/upload/file/'.$image,
					'caption' => $request->text 
				];
				$d['url_file'] = null;
		} else if($request->get('type') == "Video" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$video      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $video);
				$body = [

					'video'=>public_path().'/upload/file/'.$video,
					'caption' => $request->text 

				];
				$d['url_file'] = null;
		} else if($request->get('type') == "PDF" ) {

				$file       = $request->file('url_file');
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$doc      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $doc);
				$body = [
					'document'=> public_path().'/upload/file/'.$doc,
					'caption' => $request->text,
					'fileName' => $namaFile
				];
				$d['url_file'] = null;
		}

		if($request->device_method == 'autoswitch_device') {
			// Ambil perangkat yang statusnya "connected"
			$devices = Device::where('user_id', Auth::id())->where('status', '=', 'connected')->get();
			$totalDevices = count($devices); // Total perangkat yang tersedia
			$messageCount = 0; // Counter untuk pesan
			$deviceIndex = 0;  // Index untuk mengatur perangkat
			$maxMessage = $request->maxMessage;  // Maksimal 10 pesan per perangkat
		
			// Ambil kontak dalam chunk 100
			Contact::select('phone_number')->chunk(100, function($contacts) use ($body, $devices, &$messageCount, &$deviceIndex, $totalDevices, $maxMessage, $request, &$d) {
				foreach ($contacts as $index => $a) {
					// Ambil device saat ini berdasarkan deviceIndex
					$currentDevice = $devices[$deviceIndex];
					$d['waKey'] = $currentDevice->id; // Set device ID di data array
		
					// Menghitung delay berdasarkan index pesan
					$delay = ($index + 1) * $request->second;
					$number = $a->phone_number . '@s.whatsapp.net';
		
					// Dispatch job untuk mengirim pesan ke nomor
					dispatch(new SendBulkMessageJob($number, $body, $d, $a->phone_number))->delay(now()->addSeconds($delay));
		
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
			Contact::select('phone_number')->chunk(100, function($contacts) use ($body, $request, $d) {
				foreach ($contacts as $index => $a) {
					$delay = ($index+1) * $request->second;
					$number = $a->phone_number . '@s.whatsapp.net';
					dispatch(new SendBulkMessageJob($number, $body, $d, $a->phone_number))->delay(now()->addSeconds($delay));
				}
			});
		}
		
		toast('Bulk Message berhasil dibuat!','success');
		return redirect()->route('admin.history-messages');

    }
}