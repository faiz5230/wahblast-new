<?php

namespace App\Http\Controllers;

use App\Models\IncomingMessage;
use Illuminate\Http\Request;

class IncomingMessageController extends Controller
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
            'bot_id' => 'required'
        ],[
            'message.required' => 'Pesan tidak boleh dikosongkan',
            'bot_id.required' => 'Bot Id tidak boleh dikosongkan'
        ]);
        IncomingMessage::create($request->all());
        toast('Berhasil menambahkan step incoming message', 'success');
        return redirect()->route('admin.bot-auto-reply.edit-auto-reply', [$request->bot_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncomingMessage  $incomingMessage
     * @return \Illuminate\Http\Response
     */
    public function show(IncomingMessage $incomingMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncomingMessage  $incomingMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomingMessage $incomingMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomingMessage  $incomingMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IncomingMessage $incomingMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncomingMessage  $incomingMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomingMessage $incomingMessage)
    {
        //
    }
}
