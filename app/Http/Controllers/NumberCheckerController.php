<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\HistoryNumberChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class NumberCheckerController extends Controller
{
    public function index()
    {
        return view('admin.number-checker.index');
    }

    public function process(Request $request)
    {
        $device = Device::where('user_id', Auth::id())->where('status', 'connected')->first();
        if(!$device) {
            toast('Pengecekan gagal, tidak ada device yang aktif!','warning');
            return redirect()->back();
        }
        $getResponse = Http::withBody(
			http_build_query(['waKey' => $device->id]), 'application/x-www-form-urlencoded'
		)->send('GET', env('URL_WA_SERVER').'/connect');

		if($getResponse->status() == 500)
		{
			toast('Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya','error');
			return redirect()->route('admin.number-checker');
		}

		if($getResponse->status() != 200)
		{
			Device::whereId($request->waKey)->first()->update(['status' => 'disconnected']);
			toast('koneksi anda terputus!','warning ');
			return redirect()->route('admin.number-checker');
		}

        $response = Http::post(env('URL_WA_SERVER').'/checkNumber', [
            'waKey' => $device->id,
            'phone_number' => $request->phone_number
        ]);

        $decode = json_decode($response->getBody());
        HistoryNumberChecker::create([
            'phone_number' => $request->phone_number,
            'status' => $decode->status,
            'status_code' => $decode->statusCode,
            'message' => $decode->message
        ]);
        if($decode->statusCode == 200 && $decode->status) {
            alert()->success('Hasil Pengecekan :',$decode->message);
        } else{
            alert()->info('Hasil Pengecekan :',$decode->message);
        }

        return redirect()->route('admin.number-checker');
    }
}
