<?php

namespace App\Console\Commands;

use App\Models\Chat;
use App\Models\Device;
use App\Models\SystemSetting;
use App\Models\TemporaryChat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class executeTemporaryChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execute:temporary_chats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute Temporary Chats';

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
        // Ambil daftar perangkat yang statusnya 'connected'
        $devices = Device::where('status', 'connected')->get();

        foreach ($devices as $device) {
            $counter = 0;
            // Ambil daftar TemporaryChat yang statusnya 0 dan id_device sesuai dengan device
            $temporaryChats = TemporaryChat::where('status', 0)->where('id_device', $device->id)->get();

            foreach ($temporaryChats as $temporaryChat) {
                $this->info("Processing temporary chat with ID: {$temporaryChat->id} for device: {$device->id}");

                $getResponse = Http::withBody(
                    http_build_query(['waKey' => $device->id]), 'application/x-www-form-urlencoded'
                )->send('GET', env('URL_WA_SERVER').'/connect');
        
                // Cek status server
                if ($getResponse->status() == 500) {
                    Device::whereId($device->id)->first()->update(['status' => 'disconnected']);
                    return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!']);
                }
                
                if ($getResponse->status() != 200) {
                    Device::whereId($device->id)->first()->update(['status' => 'disconnected']);
                    return response()->json(['message' => 'Gagal mengirim pesan']);
                }

                $number = $temporaryChat->number;
                $reg = 62;
                $getNumberFormat = [];

                // Tentukan tipe pesan
                if ($temporaryChat->type === 'text') {
                    $body = $temporaryChat->text;
                } elseif ($temporaryChat->type === 'image') {
                    $body = [
                        'image' => $temporaryChat->url_file,
                        'caption' => $temporaryChat->text
                    ];
                } elseif ($temporaryChat->type === 'video') {
                    $body = [
                        'video' => $temporaryChat->url_file,
                        'caption' => $temporaryChat->text
                    ];
                } else {
                    $body = [
                        'document' => $temporaryChat->url_file,
                        'caption' => $temporaryChat->text,
                        'fileName' => 'text'
                    ];
                }

                if ($number[0] == 0) {
                    $getNumberFormat = $reg . substr($number, 1);
                    $receiverNumber = $getNumberFormat . '@s.whatsapp.net';
                    $response = Http::post(env('URL_WA_SERVER').'/send-message', [
                        'id' => $receiverNumber,
                        'text' => $body
                    ]);
                } elseif ($number[0] == 6) {
                    $receiverNumber = $number . '@s.whatsapp.net';
                    $response = Http::post(env('URL_WA_SERVER').'/send-message', [
                        'id' => $receiverNumber,
                        'text' => $body
                    ]);
                }

                if($response['status']){
                    $status = 100;
                }else{
                    $status = 0;
                }

                Chat::create([
                    'id_device' => $device->id,
                    'number' => $device->number,
                    'text' => $temporaryChat->text,
                    'type' => 'text',
                    'user_id' => $device->user_id,
                    'status' => $status
                ]); 

                // Update status TemporaryChat setelah pesan dikirim
                $temporaryChat->update(['status' => 1]);

                $counter++;

                // Log berapa banyak pesan yang sudah diproses
                $this->line("Processed {$counter} messages for device: {$device->id}");

                // Jika sudah mencapai jumlah pesan tertentu, tidur selama delay yang ditentukan
                if ($counter % SystemSetting::getValue('setting_number_of_message') == 0) {
                    $this->comment("Sleeping for " . SystemSetting::getValue('setting_delay_message') . " seconds...");
                    sleep(SystemSetting::getValue('setting_delay_message'));
                }
            }

            $this->info("Finished processing all temporary chats for device: {$device->id}");
        }
    }
}
