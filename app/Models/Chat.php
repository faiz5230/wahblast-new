<?php

namespace App\Models;

use App\Enums\StatusMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = "chats";
    protected $fillable = ['number','text','status','id_device','type','url_file', 'from_name', 'user_id'];
    protected $appends = ['status_name', 'status_color'];

    public function devices()
    {
        return $this->belongsTo(Device::class, 'id_device');
    }

    public function getStatusNameAttribute()
    {
        return StatusMessage::from($this->status)->alias();
    }

    public function getStatusColorAttribute()
    {
        return StatusMessage::from($this->status)->color();
    }
}
