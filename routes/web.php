<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminDeviceController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutoReplyController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomingMessageController;
use App\Http\Controllers\MenuMessageController;
use App\Http\Controllers\NumberCheckerController;
use App\Http\Controllers\ReplyMessageController;
use App\Http\Controllers\ScheduleSendGroupMessageTaskController;
use App\Http\Controllers\ScheduleSendMessageTaskController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\TemplateMessageController;
use App\Http\Controllers\UserController;
use App\Models\AutoReply;
use App\Models\Chat;
use App\Models\Device;
use App\Models\IncomingMessage;
use App\Models\ReplyMessage;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('admin.auth.login');
});

Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/postlogin', [AuthController::class, 'postLogin'])->name('admin.postLogin');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::group(['middleware' => 'auth'], function () {

    Route::prefix('admin')->group(function() {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

        // Device routes
        Route::prefix('device')->group(function() {
            Route::get('/', [AdminDeviceController::class, 'index'])->name('admin.device');
            Route::get('/scan/{waKey}', [AdminDeviceController::class, 'scan'])->name('admin.device.scan');
            Route::get('/disconnect/{name}', [AdminDeviceController::class, 'disconnect'])->name('admin.device.disconnect');
            Route::get('/checkConnection/{waKey}', [AdminDeviceController::class, 'checkConnection'])->name('admin.device.checkConnection');
            Route::get('/addDevice', [AdminDeviceController::class, 'addDevice'])->name('admin.device.addDevice');
            Route::post('/postDevice', [AdminDeviceController::class, 'postDevice'])->name('admin.device.postDevice');
            Route::get('/deleteDevice/{device}', [AdminDeviceController::class, 'deleteDevice'])->name('admin.device.deleteDevice');
            Route::get('/edit/{id}', [AdminDeviceController::class, 'editDevice'])->name('admin.device.edit');
            Route::put('/updateDevice/{id}', [AdminDeviceController::class, 'updateDevice'])->name('admin.device.update');
            Route::get('/show/{id}', [AdminDeviceController::class, 'show'])->name('admin.device.show');
        });

        // Chats routes
        Route::prefix('chats')->group(function() {
            Route::get('/', [ChatsController::class, 'chats'])->name('admin.chats');
            Route::get('/addChat', [ChatsController::class, 'addChat'])->name('admin.chats.addChat');
            Route::get('/addChat/{number}', [ChatsController::class, 'addChatByNumber'])->name('admin.chats.addChatByNumber');
            Route::post('/sendChat', [ChatsController::class, 'sendChat'])->name('admin.chats.sendChat');
            Route::get('/detailChat/{number}', [ChatsController::class, 'chats'])->name('admin.chats.detailChat');
            Route::get('/post', [ChatsController::class, 'postChat'])->name('admin.chats.postChat');
        });

        // Messages routes
        Route::prefix('messages')->group(function() {
            Route::get('/new-message', [MenuMessageController::class, 'index'])->name('admin.messages');
            Route::post('/send-message', [MenuMessageController::class, 'sendChat'])->name('admin.send-message');
            Route::get('/send-message/{number}', [MenuMessageController::class, 'addChatByNumber'])->name('admin.send-message-by-number');
            Route::get('/history-messages', [MenuMessageController::class, 'historyMessage'])->name('admin.history-messages');
            Route::get('/send-bulk-message', [MenuMessageController::class, 'viewBulkMessage'])->name('admin.send-bulk-message');
            Route::post('/process-bulk-message', [MenuMessageController::class, 'sendBulkMessage'])->name('admin.process-bulk-message');

            
            Route::get('/schedule-message', [ScheduleSendMessageTaskController::class, 'index'])->name('admin.schedule-message');
            Route::get('/send-schedule-message', [ScheduleSendMessageTaskController::class, 'create'])->name('admin.add-schedule-message');
            Route::post('/process-schedule-message', [ScheduleSendMessageTaskController::class, 'store'])->name('admin.process-schedule-message');
            Route::get('/delete-schedule-message/{id}', [ScheduleSendMessageTaskController::class, 'destroy'])->name('admin.delete-schedule-message');
            Route::get('/edit-schedule-message/{id}', [ScheduleSendMessageTaskController::class, 'edit'])->name('admin.edit-schedule-message');
            Route::put('/update-schedule-message/{id}', [ScheduleSendMessageTaskController::class, 'update'])->name('admin.update-schedule-message');

            Route::get('/campaign', [CampaignController::class, 'index'])->name('admin.campaign');
            Route::get('/send-campaign', [CampaignController::class, 'create'])->name('admin.add-campaign');
            Route::post('/process-campaign', [CampaignController::class, 'store'])->name('admin.process-campaign');
            Route::get('/delete-campaign/{id}', [CampaignController::class, 'destroy'])->name('admin.delete-campaign');
            Route::get('/edit-campaign/{id}', [CampaignController::class, 'edit'])->name('admin.edit-campaign');
            Route::put('/update-campaign/{id}', [CampaignController::class, 'update'])->name('admin.update-campaign');
        });

        // Groups routes
        Route::prefix('groups')->group(function() {
            Route::get('/', [GroupsController::class, 'groups'])->name('admin.groups');
            Route::get('/send-group-message', [GroupsController::class, 'sendGroupMessage'])->name('admin.send-group-message');
            Route::post('/process-group-message', [GroupsController::class, 'processGroupMessage'])->name('admin.process-group-message');
            Route::get('/get-list-group', [GroupsController::class, 'getListGroup'])->name('admin.get-list-group');
            Route::post('/process-get-list-group', [GroupsController::class, 'processGetListGroup'])->name('admin.process-get-list-group');

            Route::get('/schedule-group-message', [ScheduleSendGroupMessageTaskController::class, 'index'])->name('admin.schedule-group-message');
            Route::get('/send-schedule-group-message', [ScheduleSendGroupMessageTaskController::class, 'create'])->name('admin.add-schedule-group-message');
            Route::post('/process-schedule-group-message', [ScheduleSendGroupMessageTaskController::class, 'store'])->name('admin.process-schedule-group-message');
            Route::get('/delete-schedule-group-message/{id}', [ScheduleSendGroupMessageTaskController::class, 'destroy'])->name('admin.delete-schedule-group-message');
            Route::get('/edit-schedule-group-message/{id}', [ScheduleSendGroupMessageTaskController::class, 'edit'])->name('admin.edit-schedule-group-message');
            Route::put('/update-schedule-group-message/{id}', [ScheduleSendGroupMessageTaskController::class, 'update'])->name('admin.update-schedule-group-message');
        });

        // Contacts routes
        Route::prefix('contacts')->group(function() {
            Route::get('/', [ContactController::class, 'contacts'])->name('admin.contacts');
            Route::get('/addContact', [ContactController::class, 'addContact'])->name('admin.contacts.addContact');
            Route::post('/storeContact', [ContactController::class, 'storeContact'])->name('admin.contacts.storeContact');
            Route::get('/editContact/{id}', [ContactController::class, 'editContact'])->name('admin.contacts.editContact');
            Route::put('/updateContact/{id}', [ContactController::class, 'updateContact'])->name('admin.contacts.updateContact');
            Route::get('/destroy/{id}', [ContactController::class, 'destroyContact'])->name('admin.contacts.destroyContact');
            Route::get('/destroyAllContact', [ContactController::class, 'destroyAllContact'])->name('admin.contacts.destroyAllContact');
            Route::get('/import-contacts', [ContactController::class, 'importContacts'])->name('admin.contacts.import-contacts');
            Route::post('/process-import-contacts', [ContactController::class, 'processImportContacts'])->name('admin.contacts.process-import-contacts');
        });

        Route::get('/number-checker', [NumberCheckerController::class, 'index'])->name('admin.number-checker');
        Route::post('/process-number-checker', [NumberCheckerController::class, 'process'])->name('admin.process-number-checker');

        Route::get('/bot-auto-reply', [AutoReplyController::class, 'index'])->name('admin.bot-auto-reply');
        Route::get('/bot-auto-reply/create', [AutoReplyController::class, 'create'])->name('admin.bot-auto-reply.create');
        Route::post('/process-bot-auto-reply', [AutoReplyController::class, 'store'])->name('admin.process-bot-auto-reply');
        Route::get('/bot-auto-reply/edit-auto-reply/{id}', [AutoReplyController::class, 'editAutoReply'])->name('admin.bot-auto-reply.edit-auto-reply');
        Route::get('/bot-auto-reply/edit-bot-auto-reply/{id}', [AutoReplyController::class, 'edit'])->name('admin.bot-auto-reply.edit-bot-auto-reply');
        Route::put('/bot-auto-reply/update-bot-auto-reply/{id}', [AutoReplyController::class, 'update'])->name('admin.bot-auto-reply.update-bot-auto-reply');
        Route::get('/delete-bot-auto-reply/{id}', [AutoReplyController::class, 'delete'])->name('admin.delete-bot-auto-reply');
        // Route::get('/bot-auto-reply/{id}', [AutoReplyController::class, 'editAutoReply'])->name('admin.bot-auto-reply.edit-auto-reply');

        Route::post('/process-incoming-message', [IncomingMessageController::class, 'store'])->name('admin.process-incoming-message');
        Route::post('/process-reply-message', [ReplyMessageController::class, 'store'])->name('admin.process-reply-message');
        // Profile routes
        Route::prefix('profile')->group(function() {
            Route::get('{id}', [AccountController::class, 'profile'])->name('admin.profile');
            Route::put('/update/{id}', [AccountController::class, 'updateProfile'])->name('admin.profile.update');
        });
        
        // Account settings routes
        Route::prefix('setting-account')->group(function() {
            Route::get('{id}', [AccountController::class, 'accountSetting'])->name('admin.account-setting');
            Route::put('/change-password/{id}', [AccountController::class, 'changePassword'])->name('admin.account-setting.change-password');
        });

        Route::get('/app-setting', [AppSettingController::class, 'index'])->name('admin.app-setting');
        Route::post('/update-setting', [AppSettingController::class, 'store'])->name('admin.update-setting');

        Route::get('/system-setting', [SystemSettingController::class, 'index'])->name('admin.system-setting');
        Route::post('/update-system-setting', [SystemSettingController::class, 'store'])->name('admin.update-system-setting');

        Route::get('/template-message-setting', [TemplateMessageController::class, 'index'])->name('admin.template-message-setting');
        Route::post('/update-template-message-setting', [TemplateMessageController::class, 'store'])->name('admin.update-template-message-setting');

        // API documentation route
        Route::get('/api/documentation', function() {
            return view('api.documentation.index');
        })->name('admin.documentation-api');

        Route::resource('users', UserController::class)->only('create', 'update', 'edit', 'store', 'index');
        Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });
});

// Route::get('ok', function(){
//     $data = [
//         'id_device' => '5689256f-d1fb-44b4-a3f5-cd22907e408d',
//         'number' => '6285711974006',
//         'text' => 'asdioasidasmoidas'
//     ];
//     dd($data);
// });

// Route::get('cobain', function() {
//    dd(dispatch(new SendWAMessage)); 
// });
Route::get('/getMessage', function() {
    // Mendapatkan semua perangkat yang terhubung (status: connected)
    $devices = Device::where('status', 'connected')->get();

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
                // Pesan error toast
                return response(['message' => 'Error: Waduh, sepertinya ada yang bermasalah dengan akun WhatsApp-nya' ], 500);
            }

            // Jika respons selain 200 (misalnya terputus)
            if ($getResponse->status() != 200) {
                // Update status perangkat menjadi 'disconnected'
                $device->update(['status' => 'disconnected']);
                // Pesan peringatan toast
                return response(['message' => 'Error: Koneksi anda terputus' ], 500);
            }

            // Mengirim permintaan untuk mendapatkan pesan ke endpoint '/getMessage'
            $res = Http::post(env('URL_WA_SERVER') . '/getMessage', [
                'waKey' => $device->id // Menggunakan waKey dari perangkat yang terkait
            ]);

            // Pastikan response dari getMessage sesuai
            if ($res->failed()) {
                return redirect()->route('admin.history-messages');
            }
        }

        // Jika semua proses berhasil
        return response(['message' => 'Berhasil mendapatkan pesan']);
    } catch (\Exception $e) {
        // Tangani jika terjadi exception
        return response(['message' => 'Error: ' . $e->getMessage()], 500);
    }
});

Route::post('/webhookGetMessage', function(Request $request) {
    $bots = AutoReply::where('id_device', Device::find($request['waKey'])->id)->get();
    
    $number = str_replace('@s.whatsapp.net','',$request['from']);
    try {
        $chat = Chat::create([
            'number' => $number,
            'from_name' => $request['from_name'],
            'id_device' => $request['waKey'],
            'type' => $request['messageType'],
            'status' => $request['status'],
            'text' => $request['text'],
            'url_file' => $request['url_file'],
            'user_id' => Device::find($request['waKey'])->user_id
        ]);

        if (SystemSetting::getValue('setting_webhook') !== null) {
            try {
                $webhookUrl = SystemSetting::getValue('setting_webhook');
                $payload = [
                    'number' => $number,
                    'message' => $request['text'],
                    'device_number' => Device::whereId($request['waKey'])->first()->number, 
					'device_name' => Device::whereId($request['waKey'])->first()->name, 
                ];
        
                // Kirim permintaan HTTP POST
                $res = Http::post($webhookUrl, $payload);
        
                // Log respons untuk pengujian
                \Log::info('Webhook berhasil dipanggil', [
                    'url' => $webhookUrl,
                    'payload' => $payload,
                    'response_status' => $res->status(),
                    'response_body' => $res->body(),
                ]);
            } catch (\Exception $e) {
                // Tangkap error dan log detailnya
                \Log::error('Gagal memanggil webhook', [
                    'error_message' => $e->getMessage(),
                    'url' => $webhookUrl ?? 'Tidak ada URL',
                    'payload' => $payload ?? [],
                ]);
            }
        }

        $checkChats = Chat::where('from_name', $chat->from_name)->whereDay('created_at', Carbon::now()->day)->count();
        if($checkChats === 1)
        {
            foreach ($bots as $key => $value) {
                
            $getResponse = Http::withBody(
                http_build_query(['waKey' => $request['waKey']]), 'application/x-www-form-urlencoded'
            )->send('GET', env('URL_WA_SERVER').'/connect');
    
            if($getResponse->status() == 500)
            {
                Device::whereId($request['waKey'])->first()->update(['status' => 'disconnected']);
                return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!']);
            }
            
            if($getResponse->status() != 200)
            {
                Device::whereId($request['waKey'])->first()->update(['status' => 'disconnected']);
                return response()->json(['message' => 'gagal mengirim pesan']);
            }

            $response = Http::post(env('URL_WA_SERVER').'/send-message', [
                'id' => $number.'@s.whatsapp.net',
                'text' => $value->default_message
            ]);

            $device = Device::whereId($request['waKey'])->first();

            if(!$device)
            {
                return response()->json(['message' => 'Pesan Gagal dikirim', 'statusCode' => 500], 500);
            }

            if($response['status']){
                $status = 100;
            }else{
                $status = 0;
            }

            Chat::create([
                'id_device' => $request['waKey'],
                'number' => $number,
                'text' => $value->default_message,
                'type' => 'text',
                'status' => $status,
                'user_id' => $device->user_id
            ]); 

            if($response['status'] == 1) {		
                return response()->json(['message' => 'Pesan berhasil dikirim', 'statusCode' => 200], 200);
            }
            else {
                return response()->json(['message' => 'Pesan Gagal dikirim', 'statusCode' => 500], 500);
            }
            }
        }else {
            foreach ($bots as $key => $value) {
                $incomingMessage = IncomingMessage::where('message', $chat->text)->where('bot_id', $value->id)->whereHas('bot', function($q) {
                    $q->where('status', true);
                })->orderBy('created_at', 'asc')->first();

    
                if($incomingMessage)
                {
                    $reply = ReplyMessage::where('incoming_message_id', $incomingMessage->id)->orderBy('created_at', 'asc')->first()->message;

                    $getResponse = Http::withBody(
                        http_build_query(['waKey' => $request['waKey']]), 'application/x-www-form-urlencoded'
                    )->send('GET', env('URL_WA_SERVER').'/connect');
            
                    if($getResponse->status() == 500)
                    {
                        Device::whereId($request['waKey'])->first()->update(['status' => 'disconnected']);
                        return response()->json(['message' => 'Waduh, sepertinya ada yang bermasalah nih sama akun whatsapp nya!']);
                    }
                    
                    if($getResponse->status() != 200)
                    {
                        Device::whereId($request['waKey'])->first()->update(['status' => 'disconnected']);
                        return response()->json(['message' => 'gagal mengirim pesan']);
                    }

                    $response = Http::post(env('URL_WA_SERVER').'/send-message', [
                        'id' => $number.'@s.whatsapp.net',
                        'text' => $reply
                    ]);

                    $device = Device::whereId($request['waKey'])->first();

                    if(!$device)
                    {
                        return response()->json(['message' => 'Pesan Gagal dikirim', 'statusCode' => 500], 500);
                    }

                    if($response['status']){
                        $status = 100;
                    }else{
                        $status = 0;
                    }

                    Chat::create([
                        'id_device' => $request['waKey'],
                        'number' => $number,
                        'text' => $reply,
                        'type' => 'text',
                        'from_name' => $device->name,
                        'status' => $status,
                        'user_id' => $device->user_id
                    ]); 

                    if($response['status'] == 1) {		
                        return response()->json(['message' => 'Pesan berhasil dikirim', 'statusCode' => 200], 200);
                    }
                    else {
                        return response()->json(['message' => 'Pesan Gagal dikirim', 'statusCode' => 500], 500);
                    }
                }
            }
        }
        return response(['message' => 'Berhasil menerima pesan']);
    } catch (\Exception $e) {
        return response(['message' => 'Gagal menerima pesan']);
    }

    return response()->json(['message' => 'Pesan diterima'], 200);
});

Route::get('/sent', function() {
    $buttons = [
        ['buttonId' => 'id1', 'buttonText' => ['displayText' => 'Tombol 1'], 'type' => 1],
        ['buttonId' => 'id2', 'buttonText' => ['displayText' => 'Tombol 2'], 'type' => 1],
        ['buttonId' => 'id3', 'buttonText' => ['displayText' => 'Tombol 3'], 'type' => 1],
    ];
    
    $payload = [
        // 'footer' => 'Pilih salah satu',
        // 'buttons' => $buttons,
        'text' => 'Silakan pilih tombol di bawah:'
    ];
    

    $getResponse = Http::withBody(
        http_build_query(['waKey' => '18040f60-a78b-4f3b-852c-99e685f31a33']), 'application/x-www-form-urlencoded'
    )->send('GET', env('URL_WA_SERVER').'/connect');
    
    // Kirim pesan dengan tombol
    $response = Http::post(env('URL_WA_SERVER').'/send-message', [
        'id' => '6287777812462@s.whatsapp.net',
        'text' => $payload
    ]);
    
    // Mengembalikan respons dalam format JSON
    return response()->json([
        'status' => $response->status(),
        'body' => $response->json(),
    ]);
});
