<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\GroupChat;
use App\Models\GroupList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GroupsController extends Controller
{

	public function sendGroupApi(Request $request)
	{
		if($request->get('type') == "Text") {

			$body = $request->text;
			if($request->url_file)
			{
				return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya'], 400);
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
			return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya'], 400);
		}

		if($getResponse->status() != 200)
		{
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			return response()->json(['message' => 'koneksi anda terputus!'], 400);
		}

		$number = $request->id . '@g.us';
		$response = Http::post(env('URL_WA_SERVER').'/sendMessageToGroup', [
			'id' => $number,
			'text' => $body
		]);

		GroupChat::create([
			'id_device' => $request->waKey,
			'number' => $request->id,
			'text' => $request->text,
			'type' => $request->type,
			'user_id' => Device::whereId($request->waKey)->first()->user_id,
			'status' => $response['status']
		]); 

		if($response['status'] == 1) {		

			return response()->json(['message' => 'Pesan berhasil dikirim!', 'statusCode' => 200], 200);

		} elseif($response['status'] == 0) {

			return response()->json(['message' => 'Pesan gagal dikirim!', 'statusCode' => 400], 400);

		}
	}

	public function sendGroupWithImageApi(Request $request)
	{
		$body = [
			'image'=>['url'=> $request->get('url_file')],
			'caption'=>$request->get('text')
		];

        $reg = 62;
		$deviceNumber = $request->device_number;

		if($request->id_device)
		{
			$device = DB::table('devices')->select('id','name')->where('id',$request->get('id_device'))->first();
		}

		else{
			if($deviceNumber[0] == 0)
			{
				$getDeviceNumberFormat = $reg.substr($deviceNumber,1);
				$device = DB::table('devices')->select('id','name')->where('number',$getDeviceNumberFormat)->first();
			}

			elseif($deviceNumber[0] == 6)
			{
				$device = DB::table('devices')->select('id','name')->where('number',$request->get('device_number'))->first();
			}
		}

		$response = Http::post(env('URL_WA_SERVER').'/groups/send?id='.$device->name, [
			'receiver' => $request->groupNumber,
			'message' => $body
		]);
		
		if(!$device){
			return response('Device not Found!',500);
		}
			
		if($response->successful()){
			$res = json_decode($response->body());
			$status = $res->success ?? 0;
		} else {
			$status = 0;
		}
		
		GroupChat::create([
			'id_device' => $device->id,
			'number' => $request->groupNumber,
			'text' => $request->get('text'),
			'type' => 'Image',
			'status' => $request->get('status'),
			'user_id' => Auth::id()
		]); 

			if($request->get('status') == 1)
			{		
				return response('Berhasil terkirim',200);
			}
			elseif($request->status == 0)
			{
				return response('Gagal Terkirim',500);
			}
	}

	public function sendGroupWithDocumentApi(Request $request)
	{
		// $file       = $request->url_file;
		// 	$date       = date('d-m-Y');
		// 	$namaFile   = $file->getClientOriginalName();
		// 	$attach      = $date . '-' . $namaFile;
		// 	$file->move(public_path().'/upload/file', $attach);
		$body = [
			'document'=>['url'=> $request->get('url_file')],
			'caption'=>$request->get('text')
		];

		$number = $request->number;
        $reg = 62;
		$deviceNumber = $request->device_number;
		$getNumberFormat=[];

		if($request->id_device)
		{
			$device = DB::table('devices')->select('name')->where('id',$request->get('id_device'))->first();
		}

		else{
			if($deviceNumber[0] == 0)
			{
				$getDeviceNumberFormat = $reg.substr($deviceNumber,1);
				$device = DB::table('devices')->select('name')->where('number',$getDeviceNumberFormat)->first();
			}

			elseif($deviceNumber[0] == 6)
			{
				$device = DB::table('devices')->select('name')->where('number',$request->get('device_number'))->first();
			}
		}

        if($number[0] == 0)
        {
                $getNumberFormat = $reg.substr($number,1);
				$response = Http::post(env('URL_WA_SERVER').'/chats/send?id='.$device->name, [
					'receiver' => $getNumberFormat,
					'message' => $body
					]);
        }
		
		else if($number[0]==6)
		{
				$response = Http::post(env('URL_WA_SERVER').'/chats/send?id='.$device->name, [
					'receiver' => $number,
					'message' => $body
					]);
		}
		
		if(!$device){
			return response('Device not Found!',500);
		}
			
		if($response->successful()){
			$res = json_decode($response->body());
			$status = $res->success ?? 0;
		} else {
			$status = 0;
		}
		
		GroupChat::create([
			'id_device' => $request->get('id_device'),
			'number' => $request->number,
			'text' => $request->get('text'),
			'type' => 'text',
			'status' => $request->get('status'),
			'user_id' => Auth::id()
		]); 

			if($request->get('status') == 1)
			{		
				return response('Berhasil terkirim',200);
			}
			elseif($request->status == 0)
			{
				return response('Gagal Terkirim',500);
			}
	}

    public function groupChats()
    {
        // $GetListGroup = Http::get(env('URL_WA_SERVER').'/groups/?id='.'nazman');
		// $GetListGroupDecode = json_decode($GetListGroup);
		// $getListGroups = $GetListGroupDecode->data;
		$getListGroups = GroupChat::get();
        return view('admin.groups.groups', compact('getListGroups'));
    }

    public function sendGroupChat(Request $request)
    {
		$this->validate($request,
		[
			'number' => 'required',
			'text' => 'required',
			'type' => 'required',
			'id_device' => 'required'
		],
		[
			'number.required' => 'Group ID tidak boleh dikosongkan!',
			'text.required' => 'Pesan tidak boleh dikosongkan!',
			'type.required' => 'Type tidak boleh dikosongkan!',
			'id_device.required' => 'Device ID harus di pilih!'
		]);

			$device = DB::table('devices')->select('name')->where('id',$request->get('id_device'))->first();

			if($request->get('type') == "Text"){
				$body = ['text'=>$request->get('text')];
			}
			else if($request->get('type') == "Image" ){
				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$image      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $image);
				$body = [
					'image'=>['url'=> public_path().'/upload/file/'.$image],
					'caption'=>$request->get('text') 
				];
	
			}
			else if($request->get('type') == "Video" ){
				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$video      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $video);
				$body = [
					'video'=>['url'=> public_path().'/upload/file/'.$video],
					'caption'=>$request->get('text') 
				];
			}
			else if($request->get('type') == "PDF" ){
				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$doc      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $doc);
				$body = [
					'document'=>['url'=> public_path().'/upload/file/'.$doc],
					'caption'=> $request->get('text')
				];
			}

			//send api
			$response = Http::post(env('URL_WA_SERVER').'/groups/send?id='.$device->name, [
				'receiver' => $request->number,
				'message' => $body
				]);

                $res = json_decode($response->getBody());
				$request->get('status') = $res->success;
				GroupChat::create([
					'number' => $request->get('number'),
					'text' => $request->get('text'),
					'status' => $request->get('status'),
					'id_device' => $request->get('id_device'),
					'type' => $request->get('type'),
					'user_id' => Auth::id()
				]);
				toast('Pesan berhasil terkirim ke Grup','success');
				// $request->get('status') = $res->success;
			
			return redirect()->route('admin.groupChats');
    }

	public function groups()
	{
        $devices = Device::where('user_id', Auth::id())->get(); 
		$groupChatLogs = GroupChat::where('user_id', Auth::id())->get(); 
        return view('admin.groups.history-group-messages', compact('devices', 'groupChatLogs'));
	}

	public function sendGroupMessage()
    {
		$devices = Device::where('user_id', Auth::id())->where('status','=','connected')->get(); 
        return view('admin.groups.add-group-chat', compact('devices'));
    }

	public function processGroupMessage(Request $request)
	{
		if(Auth::user()->status_account == 'demo')
        {
            toast('Akses dibatasi! status akun hanya demo','error');
            return redirect()->route('admin.dashboard');
        }

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

		// if($getResponse->status() == 500)
		// {
		// 	Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
		// 	return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!']);
		// }

		// if($getResponse->status() != 200)
		// {
		// 	Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
		// 	return response()->json(['message' => 'gagal mengirim pesan']);
		// }
		if($getResponse->status() == 500)
		{
			toast('Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya','error');
			return redirect()->route('admin.number-checker');
		}

		if($getResponse->status() != 200)
		{
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			toast('koneksi anda terputus!','warning ');
			return redirect()->route('admin.number-checker');
		}

		$numbers_in_arrays = explode( ',' , $request->input( 'number' ) );

		foreach($numbers_in_arrays as $a)
		{
			// $countLogChat = GroupChat::where('id_device', $request->waKey)->count();
			// $limitMessageDevice = Device::whereId($request->key)->count();
			// if($countLogChat > $limitMessageDevice)
			// {
			// 	toast('Pesan anda kami limit! karna hanya akun demo','error');
			// 	return redirect()->route('admin.history-messages');
			// }

			$number = $a . '@g.us';
			$response = Http::post(env('URL_WA_SERVER').'/sendMessageToGroup', [
				'id' => $number,
				'text' => $body
			]);

			GroupChat::create([
				'id_device' => $request->waKey,
				'number' => $a,
				'text' => $request->text,
				'type' => $request->type,
				'status' => $response['status'],
				'user_id' => Auth::id()
			]); 
		}


		if($response['status'] == 1) {		

			toast('Pesan berhasil terkirim!','success');

		} elseif($response['status'] == 0) {

			toast('Pesan gagal dikirim!','error');

		}

		return redirect()->route('admin.groups');
	}

	public function getListGroup()
	{
		if(Auth::user()->status_account == 'demo')
        {
            toast('Akses dibatasi! status akun hanya demo','error');
            return redirect()->route('admin.dashboard');
        }

		$getListGroups = GroupList::with('devices')->get();
		$devices = Device::where('user_id', Auth::id())->where('status','=','connected')->get(); 

        return view('admin.groups.list-group', compact('getListGroups', 'devices'));
	}

	public function processGetListGroup(Request $request)
	{
		$getResponse = Http::withBody(
			http_build_query(['waKey' => $request->waKey]), 'application/x-www-form-urlencoded'
		)->send('GET', env('URL_WA_SERVER').'/connect');

		if($getResponse->status() == 500)
		{
			toast('Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya','error');
			return redirect()->route('admin.number-checker');
		}

		if($getResponse->status() != 200)
		{
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			toast('koneksi anda terputus!','warning ');
			return redirect()->route('admin.number-checker');
		}

		$response = Http::post(env('URL_WA_SERVER').'/getListGroup', [
			'waKey' => $request->waKey,
		]);

		$groups = json_decode($response->getBody());

		foreach ($groups->groups as $key => $value) {
			GroupList::updateOrCreate([
				'group_id' => $value->id,
			],
			[	
				'group_name' => $value->subject,
				'id_device' => $request->waKey
			]);
		}

		toast('Group berhasil didapatkan', 'success');
		return redirect()->route('admin.get-list-group');
	}
}
