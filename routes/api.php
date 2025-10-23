<?php

use App\Http\Controllers\AdminDeviceController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\MessageApiController;
use App\Http\Controllers\TemporaryChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('send-message', [TemporaryChatController::class, 'processTemporaryChat']);
Route::post('send-group-message', [GroupsController::class, 'sendGroupApi']);
// Route::post('send-message', [MessageApiController::class, 'sendChatApi']);

Route::post('devices', [AdminDeviceController::class, 'indexApi']);
Route::post('device/scan', [AdminDeviceController::class, 'scanApi']);

Route::post('contacts', [ContactController::class, 'contactsApi']);

// Route::post('send', [ChatsController::class, 'sendChatApi']);
// Route::post('send-with-image', [ChatsController::class, 'sendChatWithImageApi']);
// Route::post('send-with-document', [ChatsController::class, 'sendChatWithDocumentApi']);

// Route::post('group/send', [GroupsController::class, 'sendGroupApi']);
// Route::post('group/send-with-image', [GroupsController::class, 'sendGroupWithImageApi']);
// Route::post('group/send-with-document', [GroupsController::class, 'sendGroupWithDocumentApi']);