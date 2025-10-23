<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryChat extends Model
{
    use HasFactory;

    protected $fillable = ['number','text','status','id_device','type','url_file', 'from_name'];
}
