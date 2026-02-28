<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'category',
        'message',
    ];

    // カテゴリーの定数
    const CATEGORIES = [
        'product' => '商品について',
        'order' => '注文について',
        'shipping' => '配送について',
        'payment' => 'お支払いについて',
        'return' => '返品・交換について',
        'technical' => '技術的な問題',
        'other' => 'その他',
    ];

    public function getCategoryNameAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}