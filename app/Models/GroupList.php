<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupList extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'group_name',
        'id_device'
    ];

    public function devices()
    {
        return $this->belongsTo(Device::class, 'id_device');
    }
}
