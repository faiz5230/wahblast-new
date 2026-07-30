<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $systemSetting = SystemSetting::get();
        return view('admin.settings.system-setting', compact('systemSetting'));
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
        if(Auth::user()->status_account == 'demo')
        {
            toast('Akses dibatasi! status akun hanya demo','error');
            return redirect()->back();
        }
        if($request->setting_webhook || $request->setting_webhook == null) {
            // $this->validate($request, [
            //     'setting_webhook' => 'required|url'
            // ]);
            SystemSetting::where('key', 'setting_webhook')->first()->update(['value' => $request->setting_webhook]);
        }

        if($request->setting_number_of_message || $request->setting_number_of_message == null) {
            SystemSetting::where('key', 'setting_number_of_message')->first()->update(['value' => $request->setting_number_of_message]);
        }

        if($request->setting_delay_message || $request->setting_delay_message == null) {
            SystemSetting::where('key', 'setting_delay_message')->first()->update(['value' => $request->setting_delay_message]);
        }

        toast('System setting berhasil diupdate!', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SystemSetting  $systemSetting
     * @return \Illuminate\Http\Response
     */
    public function show(SystemSetting $systemSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SystemSetting  $systemSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemSetting $systemSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemSetting  $systemSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemSetting $systemSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SystemSetting  $systemSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemSetting $systemSetting)
    {
        //
    }
}
