<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\ScheduleSendGroupMessageTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleSendGroupMessageTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataSchedules = ScheduleSendGroupMessageTask::where('user_id', Auth::id())->get();
        return view('admin.groups.schedule-group-message', compact('dataSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $devices = Device::where('user_id', Auth::id())->where('status','=','connected')->get(); 
        return view('admin.groups.send-schedule-group-message', compact('devices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'number' => 'required',
            'waKey' => 'required',
            'schedule_date' => 'required',
            'schedule_time' => 'required',
            'text' => 'required|min:8',
            'type' => 'required'
        ],
        [
            'number.required' => 'Nomor tidak boleh dikosongkan!',
            'number.numeric' => 'Nomor harus berisi angka!',
            'waKey.required' => 'Device ID harus di pilih terlebih dahulu!',
            'text.required' => 'Pesan tidak boleh dikosongkan!',
            'schedule_date.required' => 'Schedule date tidak boleh dikosongkan!',
            'schedule_time.required' => 'Schedule time tidak boleh dikosongkan!',
            'text.min' => 'Pesan minimal 8 karakter',
            'type.required' => 'Type harus di pilih terlebih dahulu!'
        ]);

        if($request['type'] == "Text") {
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

                    'image'=>public_path().'/upload/file/image/'.$doc,
                    'caption' => $request->text 
                ];

        } else if($request['type'] == "Video" ) {

                $file       = $request->url_file;
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $file->move(public_path().'/upload/file/video', $doc);
                $body = [

                    'video'=>public_path().'/upload/file/video/'.$doc,
                    'caption' => $request->text 

                ];


        } else if($request['type'] == "PDF" ) {

                $file       = $request->file('url_file');
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $file->move(public_path().'/upload/file/document', $doc);
                $body = [
                    'document'=> public_path().'/upload/file/document/'.$doc,
                    'caption' => $request->text,
                    'fileName' => $namaFile
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

        ScheduleSendGroupMessageTask::create([
            'number' => $request->number,
            'text' => $request->text,
            'status' => false,
            'id_device' => $request->waKey,
            'schedule_date' => $request->schedule_date,
            'schedule_time' => $request->schedule_time,
            'type' => $request->type,
            'url_file' => $document,
            'file_name' => $file_name,
            'user_id' => Auth::id()
        ]);

        toast('Scheduled Message berhasil dibuat!','success');
        return redirect()->route('admin.schedule-group-message');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScheduleSendGroupMessageTask  $scheduleSendGroupMessageTask
     * @return \Illuminate\Http\Response
     */
    public function show(ScheduleSendGroupMessageTask $scheduleSendGroupMessageTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScheduleSendGroupMessageTask  $scheduleSendGroupMessageTask
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $devices = Device::where('user_id', Auth::id())->where('status','=','connected')->get(); 
        $dataSchedule = ScheduleSendGroupMessageTask::find($id);
        return view('admin.groups.edit-schedule-group-message', compact('dataSchedule', 'devices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScheduleSendMessageTask  $scheduleSendMessageTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $dataSchedule = ScheduleSendGroupMessageTask::find($id);
        if($request['type'] == "Text") {

            if($request->url_file)
            {
                toast('Anda tidak dapat mengirim file/dokumen, jika type nya text', 'warning');
                return redirect()->back();
            }
            
        } else if($request['type'] == "Image" ) {
            if($request->url_file)
            {
                
                $file       = $request->url_file;
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $folderPath = 'upload\file\document';
                if(isset($dataSchedule->url_file)){
                    unlink(public_path($folderPath). '\\'.$dataSchedule->url_file);
                }
                $file->move(public_path().'/upload/file/image', $doc);
            }

        } else if($request['type'] == "Video" ) {
            if($request->url_file)
            {
                $file       = $request->url_file;
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $folderPath = 'upload\file\document';
                if(isset($dataSchedule->url_file)){
                    unlink(public_path($folderPath). '\\'.$dataSchedule->url_file);
                }
                $file->move(public_path().'/upload/file/video', $doc);
            }
        } else if($request['type'] == "PDF" ) {
            if($request->url_file)
            {
                $file       = $request->file('url_file');
                $date       = date('d-m-Y');
                $namaFile   = $file->getClientOriginalName();
                $doc      = $date . '-' . $namaFile;
                $folderPath = 'upload\file\document';
                if(isset($dataSchedule->url_file)){
                    unlink(public_path($folderPath). '\\'.$dataSchedule->url_file);
                }
                $file->move(public_path().'/upload/file/document', $doc);
            }
        }

        if(isset($doc) && isset($namaFile))
        {
            $document = $doc;
            $file_name = $namaFile;
        }else {
            $document = $dataSchedule->url_file;
            $file_name = $dataSchedule->file_name;
        }

        $dataSchedule->update([
            'number' => $request->number,
            'text' => $request->text,
            'id_device' => $request->waKey,
            'schedule_date' => $request->schedule_date,
            'schedule_time' => $request->schedule_time,
            'type' => $request->type,
            'url_file' => $document,
            'file_name' => $file_name
        ]);

        toast('Schedule Group Message berhasil diperbarui!','success');
        return redirect()->route('admin.schedule-group-message');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScheduleSendGroupMessageTask  $scheduleSendGroupMessageTask
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataSchedule = ScheduleSendGroupMessageTask::find($id);
        $dataSchedule->delete();

        toast('Schedule Group Message berhasil dihapus!', 'success');
        return redirect()->route('admin.schedule-group-message');
    }
}
