<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateMessageController extends Controller
{
    public function index()
    {
        $templateMessage = SystemSetting::get();
        return view('admin.settings.template_message', compact('templateMessage'));
    }

    public function store(Request $request)
    {
        if(Auth::user()->status_account == 'demo')
        {
            toast('Akses dibatasi! status akun hanya demo','error');
            return redirect()->back();
        }

        $this->validate($request, [
            'setting_template_message' => 'required'
        ]);

        SystemSetting::where('key', 'setting_template_message')->first()->update(['value' => $request->setting_template_message]);

        toast('System setting berhasil diupdate!', 'success');
        return redirect()->back();
    }
}
