<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver_type',
        'number',
        'header',
        'text',
        'footer',
        'status',
        'id_device',
        'delay',
        'type',
        'url_file',
        'user_id'
    ];
}
