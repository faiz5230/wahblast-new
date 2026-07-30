<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {  
            Alert::success('Login Berhasil!','Selamat datang di ' .  AppSetting::getValue('app_title'));
            return redirect()->route('admin.dashboard');
        }else{
            toast('Gagal login, Periksa Email dan Passwordnya!','error');
            return redirect()->route('admin.login');
        }
    }

    public function logout()
    {
        Auth::logout();
        toast('Selamat, Kamu berhasil logout!','success');
        return redirect()->route('admin.login');
    }

    public function register()
    {

    }

    public function postRegister(Request $request)
    {

    }
}
