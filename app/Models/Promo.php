<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'max_uses',
        'uses',
        'valid_until',
    ];
}
