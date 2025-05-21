<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'customer_name',
    'customer_address',
    'customer_phone',
    'notes',
    'total_price',
    'discount',
    'payment_method',
    'payment_channel',
    'location',
    'status'
];

 public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}


