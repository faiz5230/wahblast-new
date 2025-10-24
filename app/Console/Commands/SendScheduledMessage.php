<?php

namespace App\Console\Commands;

use App\Models\Chat;
use App\Models\Device;
use App\Models\ScheduleSendMessageTask;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendScheduledMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:scheduled-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled messages';

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
        try {
            $currentDateTime = Carbon::now();
            $messagesScheduled = ScheduleSendMessageTask::where('schedule_date', $currentDateTime->toDateString())
                ->where('schedule_time', $currentDateTime->format('H:i'))
                ->where('status', 0)
                ->get();

            foreach ($messagesScheduled as $message) {
                if($message->type == "Text") {

                    $body = $message->text;

                }else if($message->type == "Image" ) {

                    $folderPath = 'upload\file\image';
                    $body = [

                        'image'=>public_path($folderPath).'\\'.$message->url_file,
                        'caption' => $message->text 
                    ];

                } else if($message->type == "Video" ) {

                        $folderPath = 'upload\file\video';
                        $body = [

                            'video'=>public_path($folderPath).'\\'.$message->url_file,
                            'caption' => $message->text 

                        ];


                } else if($message->type == "PDF" ) {

                        $folderPath = 'upload\file\document';
                        $body = [
                            'document'=> public_path($folderPath).'\\'.$message->url_file,
                            'caption' => $message->text,
                            'fileName' => $message->file_name
                        ];
                }

                $getResponse = Http::withBody(
                    http_build_query(['waKey' => $message->id_device]), 'application/x-www-form-urlencoded'
                    )->send('GET', env('URL_WA_SERVER').'/connect');
                
                if($getResponse->status() == 500)
                {
                    $device = Device::whereId($message->id_device)->first();
                    if ($device) {
                        $device->update(['status' => 'disconnected']);
                    }
                    $this->error('Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!');
                    continue;
                }

                if($getResponse->status() != 200)
                {
                    $device = Device::whereId($message->id_device)->first();
                    if ($device) {
                        $device->update(['status' => 'disconnected']);
                    }
                    $this->info('Device not found!');
                    continue;
                }

                $numbers_in_arrays = explode( ',' , $message->number );

                foreach($numbers_in_arrays as $a)
                {
                    $number = $a . '@s.whatsapp.net';
                    $response = Http::post(env('URL_WA_SERVER').'/send-message', [
                        'id' => $number,
                        'text' => $body
                    ]);
                }
                    
                $device = Device::whereId($message->id_device)->first();

                if(!$device)
                {
                    $this->info('Device not found!');
                    continue;
                }
                
                $message->update([
                    'status' => true
                ]);

                if($response['status']){
                    $status = 100;
                }else{
                    $status = 0;
                }

                Chat::create([
                    'id_device' => $message->id_device,
                    'number' => $message->number,
                    'from_name' => $device->name,
                    'text' => $message->text,
                    'type' => $message->type,
                    'status' => $status,
                    'user_id' => $device->user_id
                ]); 


                if(isset($message->url_file)){
                    unlink(public_path($folderPath). '\\'.$message->url_file);
                }

                $this->info('Message sent succesfully');
            }
        } catch (\Exception $e) {
            $this->info('Message sent fail');
        }
    }
}
