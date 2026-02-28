<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stock;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            ['product_id' => 1, 'quantity' => 12, 'low_stock_threshold' => 10],
            ['product_id' => 2, 'quantity' => 14, 'low_stock_threshold' => 10],
            ['product_id' => 3, 'quantity' => 106, 'low_stock_threshold' => 10],
            ['product_id' => 4, 'quantity' => 14, 'low_stock_threshold' => 10],
            ['product_id' => 5, 'quantity' => 30, 'low_stock_threshold' => 10],
            ['product_id' => 6, 'quantity' => 50, 'low_stock_threshold' => 10],
            ['product_id' => 7, 'quantity' => 60, 'low_stock_threshold' => 10],
            ['product_id' => 8, 'quantity' => 75, 'low_stock_threshold' => 10],
            ['product_id' => 9, 'quantity' => 65, 'low_stock_threshold' => 10],
            ['product_id' => 10, 'quantity' => 9, 'low_stock_threshold' => 10],
            ['product_id' => 11, 'quantity' => 134, 'low_stock_threshold' => 10],
            ['product_id' => 12, 'quantity' => 1122, 'low_stock_threshold' => 10],
            ['product_id' => 13, 'quantity' => 176, 'low_stock_threshold' => 10],
            ['product_id' => 14, 'quantity' => 1, 'low_stock_threshold' => 10],
            ['product_id' => 15, 'quantity' => 176, 'low_stock_threshold' => 10],
            ['product_id' => 16, 'quantity' => 23, 'low_stock_threshold' => 10],
            ['product_id' => 17, 'quantity' => 154, 'low_stock_threshold' => 10],
            ['product_id' => 18, 'quantity' => 8, 'low_stock_threshold' => 10],
        ];

        foreach ($stocks as $stock) {
            Stock::create($stock);
        }
    }
}
