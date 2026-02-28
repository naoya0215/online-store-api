<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // 顧客情報
            $table->string('customer_name', 100);
            $table->string('customer_email', 255);
            $table->string('customer_phone', 20);
            
            // 配送先情報
            $table->string('postal_code', 10);
            $table->string('prefecture', 20);
            $table->string('city', 100);
            $table->string('address', 255);
            $table->string('building', 255)->nullable();
            $table->text('delivery_notes')->nullable();
            
            // 決済情報
            $table->enum('payment_method', ['credit', 'bank', 'cod']);
            
            // 金額情報
            $table->integer('subtotal');
            $table->integer('shipping_fee');
            $table->integer('total_amount');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};