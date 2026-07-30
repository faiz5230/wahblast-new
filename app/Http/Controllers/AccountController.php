<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function profile($id)
    {
        $profile = User::find($id);
        return view('admin.profile.profile', compact('profile'));
    }

    public function updateProfile($id, Request $request)
    {
        if(Auth::user()->status_account == 'demo')
        {
            $account = User::find($id);
            toast('Akses dibatasi! status akun hanya demo','error');
            return redirect()->route('admin.profile', [$id]);
        }
        $profile = User::find($id);
        $profile->update($request->all());
        toast('Profile berhasil di perbarui!','success');
        return redirect()->route('admin.dashboard');
    }

    public function accountSetting($id)
    {
        $account = User::find($id);
        return view('admin.profile.accoount-setting', compact('account'));
    }

    public function changePassword($id, Request $request)
    {
        if(Auth::user()->status_account == 'demo')
        {
            toast('Akses dibatasi! status akun hanya demo','error');
            return redirect()->back();
        }
        if(!$request->password)
        {
            toast('Password tidak diperbarui!','info');
            return redirect()->back();
        }

        if(Auth::user()->status_account == 'demo')
        {
            $account = User::find($id);
            toast('Akses dibatasi! status akun hanya demo','error');
            return redirect()->route('admin.account-setting', [$id]);
        }
        $account = User::find($id);
        if($account->update([
            'password' => bcrypt($request->password)
        ])){
            toast('berhasil','success');
        }
        elseif($request->password == null)
        {
            toast('gagal','error');
        }
        toast('Password berhasil diperbarui!','success');
        return redirect()->route('admin.dashboard');
    }
}
