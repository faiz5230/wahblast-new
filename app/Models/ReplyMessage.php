<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_id',
        'incoming_message_id',
        'type',
        'message',
        'url_file'
    ];

    public function incoming()
    {
        return $this->belongsTo(IncomingMessage::class, 'incoming_message_id');
    }
}
