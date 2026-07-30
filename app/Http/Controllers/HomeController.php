<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Contact;
use App\Models\Device;
use App\Models\GroupChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $deviceStatus = Device::where('user_id', Auth::id())->where('status','=','connected')->get();
        $devices = Device::where('user_id', Auth::id())->get();
        $contacts = Contact::where('user_id', Auth::id())->get();
        $chats = Chat::where('user_id', Auth::id())->get();
        $groups = GroupChat::where('user_id', Auth::id())->get();
        // $profile = User::where('id',Auth::id())->get();
        return view('admin.dashboard', compact('devices','contacts','chats', 'groups','deviceStatus'));
    }
}
