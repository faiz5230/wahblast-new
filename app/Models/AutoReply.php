<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'id_device',
        'status',
        'default_message'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'id_device');
    }
}
