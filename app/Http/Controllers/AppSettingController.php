<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appSetting = AppSetting::get();
        return view('admin.settings.app-setting', compact('appSetting'));
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
        $this->validate($request, [
            'app_name' => 'required',
            'app_title' => 'required',
            'app_footer' => 'required'
        ]);
        if($request->app_name) {
            AppSetting::where('key', 'app_name')->first()->update(['value' => $request->app_name]);
        }

        if($request->app_title) {
            AppSetting::where('key', 'app_title')->first()->update(['value' => $request->app_title]);
        }


        if($request->app_footer) {
            AppSetting::where('key', 'app_footer')->first()->update(['value' => $request->app_footer]);
        }

        if ($request->hasFile('app_icon')) {
            if($request->app_icon){
                if(AppSetting::getValue('app_icon')!=null)
                {
                    unlink(public_path(). '\\app_setting\\' . AppSetting::getValue('app_icon'));
                }
            }
            $file = $request->file('app_icon');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Menambahkan timestamp untuk mencegah duplikasi nama file
            $file->move(public_path('app_setting'), $fileName); // Memastikan pemisah direktori
            AppSetting::where('key', 'app_icon')->first()->update(['value' => $fileName]);
        }
        
        if ($request->hasFile('app_logo')) {
            if($request->app_logo){
                if(AppSetting::getValue('app_logo')!=null)
                {
                    unlink(public_path(). '\\app_setting\\' . AppSetting::getValue('app_logo'));
                }
            }
            $file = $request->file('app_logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('app_setting'), $fileName);
            AppSetting::where('key', 'app_logo')->first()->update(['value' => $fileName]);
        }
        
        if ($request->hasFile('app_logo_full')) {
            if($request->app_logo_full){
                if(AppSetting::getValue('app_logo_full'))
                {
                    unlink(public_path(). '\\app_setting\\' . AppSetting::getValue('app_logo_full'));
                }
            }
            $file = $request->file('app_logo_full');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('app_setting'), $fileName);
            AppSetting::where('key', 'app_logo_full')->first()->update(['value' => $fileName]);
        }

        toast('App setting berhasil diupdate!', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function show(AppSetting $appSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(AppSetting $appSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppSetting $appSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppSetting $appSetting)
    {
        //
    }
}
