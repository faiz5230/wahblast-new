<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MessageApiController extends Controller
{
    public function sendChatApi(Request $request)
	{
		if(strtolower($request->get('type')) == "text") {

			$body = $request->text;

		} else if(strtolower($request->get('type')) == "image" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$doc      = $date . '-' . $namaFile;
                $folderPath = 'upload\image';
				$file->move(public_path($folderPath), '\\'.$doc);
				$body = [

					'image'=>public_path($folderPath).'\\'.$doc,
					'caption' => $request->text 
				];

		} else if(strtolower($request->get('type')) == "video" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$doc      = $date . '-' . $namaFile;
                $folderPath = 'upload\video';
				$file->move(public_path($folderPath), '\\'.$doc);
				$body = [

					'video'=>public_path($folderPath).'\\'.$doc,
					'caption' => $request->text 

				];


		} else if(strtolower($request->get('type')) == "pdf" ) {

                $file       = $request->file('url_file');
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $folderPath = 'upload\document';
                $file->move(public_path($folderPath), '\\'.$doc);
                $body = [
                    'document'=> public_path($folderPath).'\\'.$doc,
                    'caption' => $request->text,
                    'fileName' => $namaFile
                ];
        } else {
			return response()->json(['message' => 'Permintaan anda gagal, silahkan cek kembali parameter!'], );
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

		if(!$device)
		{
			return response()->json(['message' => 'Pesan Gagal dikirim', 'statusCode' => 500], 500);
		}

		if($response['status']){
			$status = 100;
		}else{
			$status = 0;
		}

		Chat::create([
			'id_device' => $request->waKey,
			'number' => $device->number,
			'text' => $request->get('text'),
			'type' => 'text',
			'status' => $status,
			'user_id' => $device->user_id
		]); 

		if($response['status'] == 1) {		
            if(isset($doc)){
                unlink(public_path($folderPath). '\\'.$doc);
            }
			return response()->json(['message' => 'Pesan berhasil dikirim', 'statusCode' => 200], 200);
		}
		else {
			return response()->json(['message' => 'Pesan Gagal dikirim', 'statusCode' => 500], 500);
		}

	}
}
