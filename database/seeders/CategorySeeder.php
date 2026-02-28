<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'エレクトロニクス', 'display_order' => 1],
            ['name' => 'スポーツ用品', 'display_order' => 2],
            ['name' => 'ファッション', 'display_order' => 3],
            ['name' => 'ホーム&ガーデン', 'display_order' => 4],
            ['name' => '本・雑誌', 'display_order' => 5],
            ['name' => '食品・飲料', 'display_order' => 6],
            ['name' => '美容・健康', 'display_order' => 7],
            ['name' => 'おもちゃ・ゲーム', 'display_order' => 8],
            ['name' => '自動車用品', 'display_order' => 9],
            ['name' => 'ペット用品', 'display_order' => 10],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
