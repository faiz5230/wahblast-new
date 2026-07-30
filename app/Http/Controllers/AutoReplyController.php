<?php

namespace App\Http\Controllers;

use App\Models\AutoReply;
use App\Models\Device;
use App\Models\IncomingMessage;
use App\Models\ReplyMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bots = AutoReply::with('device')->get();
        return view('admin.bot-autoreply.index', compact('bots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->status_account == 'demo')
        {
            toast('Akses dibatasi! status akun hanya demo','error');
            return redirect()->route('admin.bot-auto-reply');
        }
        $devices = Device::where('status', 'connected')->get();
        return view('admin.bot-autoreply.create', compact('devices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'waKey' => 'required',
            'status' => 'required'
        ],[
            'title.required' => 'Title tidak boleh dikosongkan',
            'waKey.required' => 'Device tidak boleh dikosongkan',
            'status.required' => 'Status tidak boleh dikosongkan'
        ]);

        if($request->status == 'on')
        {
            $request['status'] = 1;
        }else{
            $request['status'] = 0;
        }

        AutoReply::create([
            'title' => $request->title,
            'id_device' => $request->waKey,
            'status' => $request->status,
            'default_message' => $request->default_message
        ]);

        toast('Bot berhasil dibuat', 'success');
        return redirect()->route('admin.bot-auto-reply');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AutoReply  $autoReply
     * @return \Illuminate\Http\Response
     */
    public function show(AutoReply $autoReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AutoReply  $autoReply
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $autoReply = AutoReply::find($id);
        $devices = Device::where('status', 'connected')->get();
        return view('admin.bot-autoreply.edit', compact('devices', 'autoReply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AutoReply  $autoReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'waKey' => 'required',
        ],[
            'title.required' => 'Title tidak boleh dikosongkan',
            'waKey.required' => 'Device tidak boleh dikosongkan',
        ]);

        if($request->status == 'on')
        {
            $request['status'] = 1;
        }else{
            $request['status'] = 0;
        }

        $autoReply = AutoReply::find($id);
        $autoReply->update($request->all());

        toast('Bot berhasil diperbarui', 'success');
        return redirect()->route('admin.bot-auto-reply');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AutoReply  $autoReply
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $bot = AutoReply::find($id);
        $bot->delete();
        toast('Bot berhasil dihapus', 'success');
        return redirect()->route('admin.bot-auto-reply');
    }

    public function editAutoReply($id)
    {
        $incomingMessage = IncomingMessage::whereBotId($id)->get();
        $replyMessage = ReplyMessage::whereBotId($id)->get();
        return view('admin.bot-autoreply.edit-auto-reply', compact('incomingMessage', 'replyMessage', 'id'));
    }
}
