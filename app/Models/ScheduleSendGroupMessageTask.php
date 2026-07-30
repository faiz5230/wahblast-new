<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleSendGroupMessageTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'text',
        'status',
        'id_device',
        'schedule_date',
        'schedule_time',
        'type',
        'url_file',
        'file_name',
        'user_id'
    ];

    public function devices()
    {
        return $this->belongsTo(Device::class, 'id_device');
    }
}
