<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function getValue($key)
    {
        return static::where('key', $key)->value('value');
    }
}
