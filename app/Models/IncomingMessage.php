<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_id',
        'message'
    ];

    public function bot()
    {
        return $this->belongsTo(AutoReply::class, 'bot_id');
    }
}
