<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\SystemSetting;
use App\Models\TemporaryChat;
use Illuminate\Http\Request;

class TemporaryChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileBody = null;
        if(strtolower($request['type']) == "text") {

			$body = $request->text;

		} else if(strtolower($request['type']) == "image" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$doc      = $date . '-' . $namaFile;
                $folderPath = 'upload\image';
				$file->move(public_path($folderPath), '\\'.$doc);
                $fileBody =public_path($folderPath).'\\'.$doc;
				$body = [

					'image'=>public_path($folderPath).'\\'.$doc,
					'caption' => $request->text 
				];

		} else if(strtolower($request['type']) == "video" ) {

				$file       = $request->url_file;
				$date       = date('d-m-Y');
				$namaFile   = $file->getClientOriginalName();
				$doc      = $date . '-' . $namaFile;
                $folderPath = 'upload\video';
				$file->move(public_path($folderPath), '\\'.$doc);
                $fileBody =public_path($folderPath).'\\'.$doc;
				$body = [

					'video'=>public_path($folderPath).'\\'.$doc,
					'caption' => $request->text 

				];


		} else if(strtolower($request['type']) == "pdf" ) {

                $file       = $request->file('url_file');
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $folderPath = 'upload\document';
                $file->move(public_path($folderPath), '\\'.$doc);
                $fileBody = public_path($folderPath).'\\'.$doc;
                $body = [
                    'document'=> public_path($folderPath).'\\'.$doc,
                    'caption' => $request->text,
                    'fileName' => $namaFile
                ];
        } else {
			return response()->json(['message' => 'Permintaan anda gagal, silahkan cek kembali parameter!'], );
		}


        $device = Device::whereId($request->waKey)->first();

        TemporaryChat::create([
			'id_device' => $request->waKey,
			'number' => $device->number,
			'text' => $request->get('text'),
			'type' => 'text',
            'url_file' => $fileBody,
            'status' => 0
		]); 
    }

    public function processTemporaryChat(Request $request)
    {
        if(SystemSetting::getValue('setting_number_of_message') != null && SystemSetting::getValue('setting_delay_message') != null)
        {
            return $this->store($request);
        }else{
            return (new MessageApiController)->sendChatApi($request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TemporaryChat  $temporaryChat
     * @return \Illuminate\Http\Response
     */
    public function show(TemporaryChat $temporaryChat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TemporaryChat  $temporaryChat
     * @return \Illuminate\Http\Response
     */
    public function edit(TemporaryChat $temporaryChat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TemporaryChat  $temporaryChat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TemporaryChat $temporaryChat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TemporaryChat  $temporaryChat
     * @return \Illuminate\Http\Response
     */
    public function destroy(TemporaryChat $temporaryChat)
    {
        //
    }
}
