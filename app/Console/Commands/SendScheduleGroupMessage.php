<?php

namespace App\Console\Commands;

use App\Models\Device;
use App\Models\GroupChat;
use App\Models\ScheduleSendGroupMessageTask;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendScheduleGroupMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:scheduled-group-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled group messages';

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
            $messagesScheduled = ScheduleSendGroupMessageTask::where('schedule_date', $currentDateTime->toDateString())
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
                    Device::whereId($message->id_device)->first()->update(['status' => 'disconnected']);
                    return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!']);
                }
                
                if($getResponse->status() != 200)
                {
                    Device::whereId($message->id_device)->first()->update(['status' => 'disconnected']);
                    $this->info('Device not found!');
                    continue;
                }

                $numbers_in_arrays = explode( ',' , $message->number );

                $device = Device::whereId($message->id_device)->first();
                foreach($numbers_in_arrays as $a)
                {
        
                    $number = $a . '@g.us';
                    $response = Http::post(env('URL_WA_SERVER').'/sendMessageToGroup', [
                        'id' => $number,
                        'text' => $body
                    ]);
        
                    GroupChat::create([
                        'id_device' => $message->id_device,
                        'number' => $a,
                        'text' => $message->text,
                        'type' => $message->type,
                        'status' => $response['status'],
                        'user_id' => $device->user_id
                    ]); 
                }
                    

                if(!$device)
                {
                    $this->info('Device not found!');
                    continue;
                }
                
                $message->update([
                    'status' => true
                ]);

                if(isset($message->url_file)){
                    unlink(public_path($folderPath). '\\'.$message->url_file);
                }

                $this->info('Message sent succesfully');
            }
        } catch (\Exception $e) {
            $this->info('Group Message sent fail');
        }
    }
}
