<?php

namespace App\Jobs;

use App\Models\Chat;
use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendBulkMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public string $number,
        public string $body,
        public array $data,
        public string $number_format
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $getResponse = Http::withBody(
                http_build_query(['waKey' => $this->data['waKey']]), 'application/x-www-form-urlencoded'
            )->send('GET', env('URL_WA_SERVER').'/connect');
    
            if($getResponse->status() == 500)
            {
                $device = Device::whereId($this->data['waKey'])->first();
                if ($device) {
                    $device->update(['status' => 'disconnected']);
                }
                return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!']);
            }

            if($getResponse->status() != 200)
            {
                $device = Device::whereId($this->data['waKey'])->first();
                if ($device) {
                    $device->update(['status' => 'disconnected']);
                }
                \Log::error('Gagal mengirim pesan, status: ' . $getResponse['status']);
                return;
            }
    
            $response = Http::post(env('URL_WA_SERVER').'/send-message', [
                'id' => $this->number,
                'text' => $this->body
            ]);

            if($response['status']){
				$status = 100;
			}else{
				$status = 0;
			}
    
            Chat::create([
                'id_device' => $this->data['waKey'],
                'number' => $this->number_format,
				'from_name' => Device::find($this->data['waKey'])->name,
                'text' => $this->data['text'],
                'type' => $this->data['type'],
                'status' => $status,
				'user_id' => Device::find($this->data['waKey'])->user_id
            ]); 
        } catch (\Exception $e) {
            \Log::error('Error dalam job SendBulkMessageJob: ' . $e->getMessage());
        }
    
    }
}
