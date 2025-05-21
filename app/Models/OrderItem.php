<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'menu_id', 'quantity', 'price', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
     public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}



