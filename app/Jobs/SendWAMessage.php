<?php

namespace App\Jobs;

use App\Models\Chat;
use GuzzleHttp\Psr7\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendWAMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        return $this->handle();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $data = [
        //     'id_device' => '5689256f-d1fb-44b4-a3f5-cd22907e408d',
        //     'number' => '6285711974006',
        //     'text' => 'coba wa'
        // ];
        // Http::post('http://222.165.255.152:8882/api/send?'.http_build_query($data));

        $data = [
            'id_device' => '5689256f-d1fb-44b4-a3f5-cd22907e408d',
            'number' => '6285920754983',
            'text' => 'coba wa api'
        ];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://222.165.255.152:8882/api/send?".http_build_query($data));
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS,
        //             "id_device=5689256f-d1fb-44b4-a3f5-cd22907e408d&number=6289518102081&text=value3");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);
    }
}
