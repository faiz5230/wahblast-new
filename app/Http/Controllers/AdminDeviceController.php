<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
use Alert;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class AdminDeviceController extends Controller
{
    public function index()
    {
        $device = Device::where('user_id','=',Auth::id())->get();
        return view('admin.device.device', compact('device'));
    }

    public function scan($waKey)
    {
			$response = Http::withBody(
				http_build_query(['waKey' => $waKey]), 'application/x-www-form-urlencoded'
			)->send('GET', env('URL_WA_SERVER').'/connect');
			
			$data = [];


			if($response['status'] == 200)
			{
				if(isset($response['qrCode']))
				{
					// $device = Device::whereNumber($waKey)->first();
					// $device->update(['status' => 'connected']);
					$res = json_decode($response->getBody());
					$image = $res->qrCode;
					$data['result'] = $image;
					$data['page_title'] = 'Scan Device';
					return view('admin.device.scan', compact('data'));
				}else{
					Device::whereId($waKey)->first()->update(['status' => 'connected']);
					return redirect()->route('admin.device');
				}
			}else{
				return redirect()->route('admin.device');
			}
    }

    public function disconnect($waKey)
    {
		$response = Http::withBody(
			http_build_query(['waKey' => $waKey]), 'application/x-www-form-urlencoded'
		)->send('GET', env('URL_WA_SERVER').'/disconnect');

		$res = json_decode($response->getBody());

		if(isset($res->status))
		{
			
			Device::whereId($waKey)->update(['status' => 'disconnected']);
			toast('Sesi berhasil diputus!','success');
			return redirect()->route('admin.device');
		}else{
			toast('Sesi gagal dihapus','error');
			return redirect()->route('admin.device');
		}
    }

	public function addDevice()
	{
		return view('admin.device.add-device');
	}

	public function postDevice(Request $request)
	{
		$this->validate($request,[
			'number' => 'required|numeric|min:11',
			'name' => 'required',
			'description' => 'required',
			'multidevice' => 'required',
		],
		[
			'number.required' => 'Number tidak boleh dikosongkan!',
			'number.numeric' => 'Number hanya dapat diisi oleh angka!',
			'name.required' => 'Nama tidak boleh dikosongkan',
			'description.required' => 'Deskripsi harus di isi',
			'multidevice.required' => 'Multi Device harus di isi'
		]);

		$number = $request->number;
 		$reg = 62;
		if($number[0] == 0)
		{
			$getNumberFormat = $reg.substr($number,1);
		}
		elseif($number[0] == 6)
		{
			$getNumberFormat = $request->number;
		}

		Device::create([
			'user_id' => Auth::id(),
			'number' => $getNumberFormat,
			'name' => $request->get('name'),
			'status' => $request->get('status'),
			'description' => $request->get('description'),
			'multidevice' => $request->get('multidevice'),
		]);
		toast('Device berhasil ditambah!','success');
		return redirect()->route('admin.device');
	}

	public function editDevice($id)
	{
		$device = Device::find($id);
		return view('admin.device.edit-device', compact('device'));
	}

	public function updateDevice(Request $request,$id)
	{
		$device = Device::find($id);
		$device->update($request->all());
		toast('Device berhasil diperbarui!','success');
		return redirect()->route('admin.device');
	}

	public function deleteDevice(Device $device)
	{
		if($device->status == 'connected')
		{
			toast('Device gagal dihapus! karna masih terkoneksi dengan whatsapp','error');
			return redirect()->route('admin.device');
		}
		$device->delete();
		toast('Device berhasil dihapus!','success');
		return redirect()->route('admin.device');
	}

	public function show($id)
	{
		$device = Device::find($id);
		if(!$device) {
			toast('Device yang kamu cari tidak ditemukan', 'error');
			return redirect()->route('admin.device');
		}
		return view('admin.device.show', compact('device'));
	}

	public function checkConnection($waKey)
	{
		$getResponse = Http::withBody(
			http_build_query(['waKey' => $waKey]), 'application/x-www-form-urlencoded'
		)->send('GET', env('URL_WA_SERVER').'/connect');
		

		$res = json_decode($getResponse->getBody());

		if(isset($res->qrCode))
		{
			toast("Sesi anda telah terputus", "warning");
			Device::whereId($waKey)->first()->update(['status' => 'disconnected']);
			return redirect()->route('admin.device');
		}else{
			toast("Sesi anda masih aktif", "success");
			return redirect()->route('admin.device');
		}
	}

	public function indexApi(Request $request)
    {
		if(!User::find($request->account_key))
		{
			return response()->json(['message' => 'Device gagal ditarik', 'statusCode' => 400], 400);
		}

        $device = Device::select('id', 'number', 'name', 'description', 'multidevice', 'status')->where('user_id','=', $request->account_key)->where('status', 'connected')->get();
		foreach ($device as $d) {
			$d['waKey'] = $d->id;
		}
		return response()->json(['message' => 'Semua device berhasil ditarik', 'statusCode' => 200, 'data' => $device], 200);
    }

    public function scanApi(Request $request)
    {
		if(!User::find($request->account_key))
		{
			return response()->json(['message' => 'Gagal melakukan scan', 'statusCode' => 400], 400);
		}
		$response = Http::withBody(
			http_build_query(['waKey' => $request->waKey]), 'application/x-www-form-urlencoded'
		)->send('GET', env('URL_WA_SERVER').'/connect');
		$data = [];
		
		if ($response->getStatusCode() == 200) {
			$res = $response->json(); 
		
			if (isset($res['qrCode'])) {
				$image = $res['qrCode'];
				$data['result'] = $image;
				$data['page_title'] = 'Scan Device';
				return response()->json(['message' => 'Data berhasil ditarik', 'statusCode' => 200, 'data' => $data], 200);
			} else {
				Device::whereId($request->waKey)->first()->update(['status' => 'connected']);
				return response()->json(['message' => 'Data berhasil ditarik', 'statusCode' => 200, 'data' => $data], 200);
			}
		} else {
			return response()->json(['message' => 'Data gagal didapatkan', 'statusCode' => 500], 500);
		}
    }
}
