<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'admin_id',
        'category_id',
        'name',
        'price',
        'description',
        'image_path',
        'display_order',
        'is_selling',
        'is_deleted',
    ];

    protected $casts = [
        'admin_id' => 'integer',
        'category_id' => 'integer',
        'price' => 'decimal:2',
        'display_order' => 'integer',
        'is_selling' => 'boolean',
        'is_deleted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
