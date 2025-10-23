<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $table = "devices";
    protected $fillable = ['user_id','number','name','status','description','multidevice','limit_send_message'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
