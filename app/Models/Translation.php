<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Translation extends Model
{
    use HasFactory;

    protected $casts = [
        'tags' => 'array',
    ];
    
    protected $fillable = ['locale', 'key', 'value', 'tags','content'];

    public static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('translations');
        });

        static::deleted(function () {
            Cache::forget('translations');
        });
    }
}
