<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    use HasFactory;

    protected $table = "chat_logs";
    protected $fillable = ['number','text','status','id_device','type','url_file'];

    public function devices()
    {
        return $this->belongsTo(Device::class, 'id_device');
    }
}
