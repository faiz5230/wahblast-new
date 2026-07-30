<?php

namespace App\Console\Commands;

use App\Models\Device;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetMessageComand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $devices = Device::where('status', 'connected')->get();

        if(!$devices) {
            return response(['message' => 'Gagal karna tidak ada koneksi aktif']);
        }

        try {
            // Iterasi untuk setiap device yang terhubung
            foreach ($devices as $device) {
                // Melakukan koneksi ke server WA
                $getResponse = Http::withBody(
                    http_build_query(['waKey' => $device->id]), 
                    'application/x-www-form-urlencoded'
                )->send('GET', env('URL_WA_SERVER') . '/connect');
    
                // Jika server mengembalikan status 500 (error server)
                if ($getResponse->status() == 500) {
                    $this->error('Waduh, sepertinya ada yang bermasalah dengan akun WhatsApp-nya');
                    return 1; // Mengembalikan status error
                }
    
                // Jika respons selain 200 (misalnya terputus)
                if ($getResponse->status() != 200) {
                    // Update status perangkat menjadi 'disconnected'
                    $device->update(['status' => 'disconnected']);
                    $this->warn('Koneksi Anda terputus!');
                    return 1; // Mengembalikan status error
                }
    
                // Mengirim permintaan untuk mendapatkan pesan ke endpoint '/getMessage'
                $res = Http::post(env('URL_WA_SERVER') . '/getMessage', [
                    'waKey' => $device->id // Menggunakan waKey dari perangkat yang terkait
                ]);
    
                // Pastikan response dari getMessage sesuai
                if ($res->failed()) {
                    $this->error('Gagal mendapatkan pesan dari server.');
                    return 1; // Mengembalikan status error
                }
            }
    
            // Jika semua proses berhasil
            $this->info('Berhasil mendapatkan pesan');
            return 0; // Mengembalikan status sukses
        } catch (\Exception $e) {
            // Tangani jika terjadi exception
            $this->error('Error: ' . $e->getMessage());
            return 1; // Mengembalikan status error
        }
    }
}
