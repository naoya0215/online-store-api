<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'postal_code',
        'prefecture',
        'city',
        'address',
        'building',
        'delivery_notes',
        'payment_method',
        'subtotal',
        'shipping_fee',
        'total_amount',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}