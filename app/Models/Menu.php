<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;  // Perbaiki penulisan namespace di sini
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image'
    ];
}

