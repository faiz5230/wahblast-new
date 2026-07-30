<?php

namespace App\Http\Controllers;

use App\Models\ReplyMessage;
use Illuminate\Http\Request;

class ReplyMessageController extends Controller
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
        $this->validate($request, [
            'message' => 'required',
            'bot_id' => 'required',
            'incoming_message_id' => 'required'
        ],[
            'message.required' => 'Pesan tidak boleh dikosongkan',
            'bot_id.required' => 'Bot Id tidak boleh dikosongkan',
            'incoming_message_id.required' => 'Incoming message id tidak boleh dikosongkan'
        ]);
        ReplyMessage::create($request->all());
        toast('Berhasil menambahkan step reply message', 'success');
        return redirect()->route('admin.bot-auto-reply.edit-auto-reply', [$request->bot_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReplyMessage  $replyMessage
     * @return \Illuminate\Http\Response
     */
    public function show(ReplyMessage $replyMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReplyMessage  $replyMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ReplyMessage $replyMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReplyMessage  $replyMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReplyMessage $replyMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReplyMessage  $replyMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReplyMessage $replyMessage)
    {
        //
    }
}
