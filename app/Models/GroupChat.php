<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    use HasFactory;

    protected $table = "group_chats";
    protected $fillable = ['number','text','status','id_device','type', 'user_id'];
}
