<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'iPhone 15 Pro',
                'price' => 159800,
                'description' => '最新のA17 Proチップ搭載。プロ級のカメラシステムで美しい写真と動画を撮影。',
            ],
            [
                'category_id' => 1,
                'name' => 'MacBook Air M3',
                'price' => 164800,
                'description' => '驚異的なパフォーマンスと長時間バッテリー。薄くて軽い13インチノートブック。',
            ],
            [
                'category_id' => 1,
                'name' => 'AirPods Pro (第3世代)',
                'price' => 39800,
                'description' => 'アクティブノイズキャンセリング機能付きワイヤレスイヤホン。',
            ],
            [
                'category_id' => 2,
                'name' => 'ナイキ エア ズーム ペガサス',
                'price' => 13200,
                'description' => 'ランナーに愛され続けるクッション性抜群のランニングシューズ。',
            ],
            [
                'category_id' => 2,
                'name' => 'アディダス サッカーボール',
                'price' => 3800,
                'description' => 'FIFA承認の公式試合球。優れた飛行安定性を実現。',
            ],
            [
                'category_id' => 2,
                'name' => 'ヨガマット プレミアム',
                'price' => 6800,
                'description' => '滑り止め加工で安全性抜群。厚さ6mmでクッション性も◎',
            ],
            [
                'category_id' => 3,
                'name' => 'ユニクロ ウルトラライトダウン',
                'price' => 5990,
                'description' => '軽量で暖かい、持ち運び便利なダウンジャケット。',
            ],
            [
                'category_id' => 3,
                'name' => 'カシミヤセーター',
                'price' => 25000,
                'description' => '上質なカシミヤ100%使用。肌触りが良く暖かい。',
            ],
            [
                'category_id' => 3,
                'name' => 'リーバイス 501 ジーンズ',
                'price' => 12800,
                'description' => '永遠の定番。オリジナルストレートフィットジーンズ。',
            ],
            [
                'category_id' => 4,
                'name' => '空気清浄機 プラズマクラスター',
                'price' => 28000,
                'description' => 'PM2.5対応、花粉やウイルスもしっかり除去。',
            ],
            [
                'category_id' => 4,
                'name' => 'ガーデンチェアセット',
                'price' => 24000,
                'description' => '屋外用のテーブル・チェアセット。天然木使用。',
            ],
            [
                'category_id' => 4,
                'name' => 'ロボット掃除機',
                'price' => 45000,
                'description' => 'スマート掃除で床をピカピカに。スマホ操作対応。',
            ],
            [
                'category_id' => 5,
                'name' => 'プログラミング入門書',
                'price' => 2800,
                'description' => '初心者にも分かりやすいプログラミングの基礎を学べる一冊。',
            ],
            [
                'category_id' => 5,
                'name' => 'デザイン思考の教科書',
                'price' => 3200,
                'description' => 'ビジネスに活かせるデザイン思考を体系的に学習。',
            ],
            [
                'category_id' => 5,
                'name' => '料理レシピ本',
                'price' => 1800,
                'description' => '簡単で美味しい家庭料理のレシピを300品紹介。',
            ],
            [
                'category_id' => 6,
                'name' => 'プレミアムコーヒー豆',
                'price' => 2400,
                'description' => 'ブラジル産最高級アラビカ豆。芳醇な香りと深いコク。',
            ],
            [
                'category_id' => 6,
                'name' => 'オーガニック紅茶セット',
                'price' => 3600,
                'description' => '有機栽培茶葉を使用した5種類の紅茶セット。',
            ],
            [
                'category_id' => 6,
                'name' => '高級チョコレート',
                'price' => 1800,
                'description' => 'ベルギー産カカオ使用の上質なチョコレート。',
            ],
        ];

        foreach ($products as $index => $productData) {
            $product = Product::create([
                'admin_id' => 1,
                'category_id' => $productData['category_id'],
                'name' => $productData['name'],
                'price' => $productData['price'],
                'description' => $productData['description'],
                'image_path' => null,
                'display_order' => $index + 1,
                'is_selling' => false,
                'is_deleted' => false,
            ]);
        }
    }
}
