<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Category;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==============================
        // 1. 名古屋グルメ用カテゴリを作成
        // ==============================
        $categories = [
            'ラーメン' => 'ラーメン',
            '味噌カツ' => '味噌カツ',
            '手羽先' => '手羽先',
        ];

        $categoryModels = [];

        foreach ($categories as $name => $description) {
            $categoryModels[$name] = Category::firstOrCreate(
                ['name' => $name],
                [
                    'description' => $description,
                    'major_category_id' => 1, // 適宜設定
                ]
            );
        }

        // ==============================
        // 2. 店舗を作成
        // ==============================
        $stores = [
            [
                'name' => '山本屋本店',
                'description' => '名古屋味噌煮込みうどんの有名店。',
                'address' => '名古屋市中区栄3丁目',
                'image' => 'yamamotoya.jpg',
                'category' => '味噌カツ',
                'recommend_flag' => true,
            ],
            [
                'name' => 'ラーメン一番',
                'description' => '地元で人気のラーメン店。',
                'address' => '名古屋市中村区名駅2丁目',
                'image' => 'ramen1.jpg',
                'category' => 'ラーメン',
                'recommend_flag' => false,
            ],
            [
                'name' => '世界の山ちゃん',
                'description' => '名古屋名物手羽先で有名。',
                'address' => '名古屋市中区栄4丁目',
                'image' => 'yamachan.jpg',
                'category' => '手羽先',
                'recommend_flag' => true,
            ],
        ];

        foreach ($stores as $store) {
            Store::updateOrCreate(
                ['name' => $store['name']], // 同じ名前の店舗は更新
                [
                    'description' => $store['description'],
                    'address' => $store['address'],
                    'image' => $store['image'],
                    'category_id' => $categoryModels[$store['category']]->id,
                    'recommend_flag' => $store['recommend_flag'],
                ]
            );
        }
    }
}
