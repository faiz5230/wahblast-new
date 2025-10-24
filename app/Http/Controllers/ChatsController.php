<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatLog;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;

class ChatsController extends Controller
{
    public function chats(Request $request)
    {
		$detailChat['data'] = DB::table('chats')->where('user_id', Auth::id())->where('number',$request->number)->get();
        $chats = Chat::latest()->get();
		$listChats = Chat::latest()->get();
		$uniqueChats = $listChats->unique(['number']);
		foreach($uniqueChats as $uc)
		{
			if(date('d', strtotime($uc->created_at)) == date('d'))
			{
				$time = 'today '. date('G:i:s', strtotime($uc->created_at));
				$uc['time'] = $time;
			}	
				$time = date('j F, G:i', strtotime($uc->created_at));
				$uc['time'] = $time;
		}
		Session::put('number',$request->number);
		
        return view('admin.chats.chats', compact('chats', 'uniqueChats','detailChat','request'));
    }

    public function addChat()
    {
        $devices = Device::where('status','=','connected')->get(); 
        return view('admin.chats.add-chat', compact('devices'));
    }

	public function sendChatApi(Request $request)
	{
		if($request->get('type') == "Text") {

			$body = $request->text;

		} else if($request->get('type') == "Image" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$image      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $image);
				$body = [

					'image'=>['url'=> public_path().'/upload/file/'.$image],
					'caption' => $request->text 
				];

		} else if($request->get('type') == "Video" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$video      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $video);
				$body = [

					'video'=>['url'=> public_path().'/upload/file/'.$video],
					'caption' => $request->text 

				];


		} else if($request->get('type') == "PDF" ) {

			$body = [
				'document'=>['url'=> $request->get('url_file')],
				'caption'=>$request->get('text')
			];
		}


		$getResponse = Http::withBody(
			http_build_query(['waKey' => $request->waKey]), 'application/x-www-form-urlencoded'
		)->send('GET', env('URL_WA_SERVER').'/connect');

		if($getResponse->status() == 500)
		{
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!']);
		}

		if($getResponse->status() != 200)
		{
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			return response()->json(['message' => 'gagal mengirim pesan']);
		}

		$number = $request->id;
        $reg = 62;
		$getNumberFormat=[];

		if($number[0] == 0)
		{
				$getNumberFormat = $reg.substr($number,1);
				$receiverNumber = $getNumberFormat . '@s.whatsapp.net';
				$response = Http::post(env('URL_WA_SERVER').'/send-message', [
					'id' => $receiverNumber,
					'text' => $body
				]);
		}
		
		else if($number[0]==6)
		{
			$receiverNumber = $number . '@s.whatsapp.net';
			$response = Http::post(env('URL_WA_SERVER').'/send-message', [
				'id' => $receiverNumber,
				'text' => $body
			]);
		}

		$device = Device::whereId($request->waKey)->first();

		Chat::create([
			'id_device' => $request->waKey,
			'number' => $device->number,
			'text' => $request->get('text'),
			'type' => 'text',
			'status' => $response['status'],
			'user_id' => Auth::id()
		]); 

		if($response['status'] == 1) {		
			return response()->json(['message' => 'Pesan berhasil dikirim', 'statusCode' => 200], 200);
		}
		else {
			return response()->json(['message' => 'Pesan Gagal dikirim', 'statusCode' => 500], 500);
		}

	}

	public function sendChatWithImageApi(Request $request)
	{
		$body = [
			'image'=>['url'=> $request->get('url_file')],
			'caption'=>$request->get('text')
		];

		$number = $request->number;
        $reg = 62;
		$deviceNumber = $request->device_number;
		$getNumberFormat=[];

		if($request->id_device)
		{
			$device = DB::table('devices')->select('name')->where('id',$request->get('id_device'))->first();
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
				
			$res = json_decode($response->getBody());
			$request->get('status') = $res->success;
			
			Chat::create([
				'id_device' => $request->get('id_device'),
				'number' => $request->number,
				'text' => $request->get('text'),
				'type' => 'text',
				'status' => $request->get('status'),
				'user_id' => Auth::id()
			]);

			ChatLog::create([
				'id_device' => $request->get('id_device'),
				'number' => $request->number,
				'text' => $request->get('text'),
				'type' => 'text',
			]); 
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

			else{
					$response = Http::post(env('URL_WA_SERVER').'/chats/send?id='.$device->name, [
						'receiver' => $request->number,
						'message' => $body
					]);
			}
				
			$res = json_decode($response->getBody());
			$request->get('status') = $res->success;
			
			Chat::create([
				'id_device' => $device->id,
				'number' => $request->number,
				'text' => $request->get('text'),
				'type' => 'text',
				'status' => $request->get('status'),
				'user_id' => Auth::id()
			]);

			ChatLog::create([
				'id_device' => $device->id,
				'number' => $request->number,
				'text' => $request->get('text'),
				'type' => 'text',
			]); 
		} 

			if($request->get('status') == 1)
			{		
				return response('Berhasil terkirim',200);
			}
			elseif($request->status == 0)
			{
				return response('Gagal Terkirim',500);
			}
	}

	public function sendChatWithDocumentApi(Request $request)
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

			else{
					$response = Http::post(env('URL_WA_SERVER').'/chats/send?id='.$device->name, [
						'receiver' => $request->number,
						'message' => $body
					]);
			}
			
			
			$res = json_decode($response->getBody());
			$request->get('status') = $res->success;
			
			Chat::create([
				'id_device' => $request->get('id_device'),
				'number' => $request->number,
				'text' => $request->get('text'),
				'type' => 'text',
				'status' => $request->get('status'),
				'user_id' => Auth::id()
			]); 

			ChatLog::create([
				'id_device' => $request->get('id_device'),
				'number' => $request->number,
				'text' => $request->get('text'),
				'type' => 'text',
			]); 
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

			else{
					$response = Http::post(env('URL_WA_SERVER').'/chats/send?id='.$device->name, [
						'receiver' => $request->number,
						'message' => $body
					]);
			}
			
			
			$res = json_decode($response->getBody());
			$request->get('status') = $res->success;
			
			Chat::create([
				'id_device' => $device->id,
				'number' => $request->number,
				'text' => $request->get('text'),
				'type' => 'text',
				'status' => $request->get('status'),
				'user_id' => Auth::id()
			]); 

			ChatLog::create([
				'id_device' => $device->id,
				'number' => $request->number,
				'text' => $request->get('text'),
				'type' => 'text',
			]); 
		}

		if(!$device){
			return response('Device not Found!',500);
		}

			if($request->get('status') == 1)
			{		
				return response('Berhasil terkirim',200);
			}
			elseif($request->status == 0)
			{
				return response('Gagal Terkirim',500);
			}
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

		} else if($request->get('type') == "Image" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$image      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $image);
				$body = [

					'image'=>['url'=> public_path().'/upload/file/'.$image],
					'caption' => $request->text 
				];
	
		} else if($request->get('type') == "Video" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$video      = $date . '-' . $namaFile;
				$file->move(public_path().'/upload/file', $video);
				$body = [

					'video'=>['url'=> public_path().'/upload/file/'.$video],
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
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!']);
		}
		
		if($getResponse->status() != 200)
		{
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			return response()->json(['message' => 'gagal mengirim pesan']);
		}

		$numbers_in_arrays = explode( ',' , $request->input( 'number' ) );

		foreach($numbers_in_arrays as $a)
		{
			$number = $a . '@s.whatsapp.net';
			$response = Http::post(env('URL_WA_SERVER').'/send-message', [
				'id' => $number,
				'text' => $body
			]);

			Chat::create([
				'id_device' => $request->wa_key,
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

			toast('Pesan Gagal terkirim!','error');

		}

		return redirect()->route('admin.chats');

		// 	$getNumbr = $request->get('number');
		// 	Session::put('number',$getNumbr);

		// $device = DB::table('devices')->select('name')->where('id',$request->get('id_device'))->first();

		// foreach($numbers_in_arrays as $a)
		// {
		// 	$response = Http::post(env('URL_WA_SERVER').'/chats/send?id='.$device->name, [
		// 		'receiver' => $a,
		// 		'message' => $body
		// 		]);
				
		// 	$res = json_decode($response->getBody());
		// 	$request->get('status') = $res->success;
			
		// 	Chat::create([
		// 		'id_device' => $request->get('id_device'),
		// 		'number' => $a,
		// 		'text' => $request->get('text'),
		// 		'type' => $request->get('type'),
		// 		'status' => $request->get('status')
		// 	]); 
		// }

		// 	if($request->get('status') == 1)
		// 	{		
		// 		toast('Pesan berhasil terkirim!','success');
		// 	}
		// 	elseif($request->status == 0)
		// 	{
		// 		toast('Pesan Gagal terkirim!','error');
		// 	}

		// 	$getNumbr = $request->get('number');
		// 	Session::put('number',$getNumbr);
		// 	return redirect()->route('admin.chats', ['number' => Session::get('number')]);
    }

	public function getChat(Request $request)
	{
		$GetListChat = Http::get(env('URL_WA_SERVER').'/chats/?id='.'nazman');
		$GetListChatDecode = json_decode($GetListChat);
		$getListChats = $GetListChatDecode->data;
		$getChat = Http::get(env('URL_WA_SERVER').'/chats/6285711974006@s.whatsapp.net/?id='.'nazman');
		$getChatDecode = json_decode($getChat);
		$getChatFormatter = json_decode(json_encode($getChatDecode), true);
		// foreach($getChatDecode->data as $g)
		// {
		// 	$array = json_decode(json_encode($g),true);
		// 	dd($array['message']['conversation']);
		// }
		return view('admin.chats.chats', compact('getChatFormatter','getListChats'));
	}

	public function detailChat($id)
	{
		$detailChat = Chat::find($id);
		$listChats = Chat::all();
		$uniqueChats = $listChats->unique(['number']);
		return view('admin.chats.components.detailChat', compact('detailChat','uniqueChats'));
	}

	public function postChat(Request $request)
	{
		$device = DB::table('devices')->select('name')->where('status','connected')->first();
		// $device = DB::table('devices')->select('name')->where('id','1')->first();
		$body = ['text'=>$request->get('text')];
		$response = Http::post(env('URL_WA_SERVER').'/chats/send?id='.$device->name, [
			'receiver' => Session::get('number'),
			'message' => $body
			]);
		$res = json_decode($response->getBody());
		$request->get('status') = $res->success;
		Chat::create([
			'id_device' => 1,
            'number' => Session::get('number'),
            'text' => $request->get('text'),
            'type' => 'Text',
            'status' => $request->get('status'),
			'user_id' => Auth::id()
		]);

		return redirect()->route('admin.chats', ['number' => Session::get('number')]);
	}

	public function addChatByNumber($phone_number)
	{
		$getNumber = $phone_number;
        $devices = Device::where('status','=','connected')->get(); 
		return view('admin.chats.add-chat-by-number', compact('getNumber','devices'));
	}
}
