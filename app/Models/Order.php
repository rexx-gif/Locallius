<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'menu_id',
        'quantity',
        'location',
        'total_price'
    ];

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
}
