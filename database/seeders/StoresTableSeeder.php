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
        // 1. 残すカテゴリを定義
        // ==============================
        $keepCategories = [
            'ALL',
            '和食・定食',
            '洋食',
            '寿司',
            'しゃぶしゃぶ',
            'ラーメン・つけ麺・そば・うどん',
            'お好み焼き・たこ焼き',
            'ステーキ・ハンバーグ',
            '韓国料理',
            '中華料理',
            'イタリアン',
            'カレー',
            'アジア料理',
            'ビュッフェ',
            '居酒屋',
            '喫茶店',
            'スイーツ',
        ];

        // ==============================
        // 2. 不要カテゴリを削除
        // ==============================
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // 外部キー制約を一時無効
        \DB::table('categories')->whereNotIn('name', $keepCategories)->delete();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // 外部キー制約を有効

        // ==============================
        // 3. カテゴリを作成（残すカテゴリも含む）
        // ==============================
        $categories = [
            'ALL' => 'ALL',
            '和食・定食' => '和食・定食',
            '洋食' => '洋食',
            '寿司' => '寿司',
            'しゃぶしゃぶ' => 'しゃぶしゃぶ',
            'ラーメン・つけ麺・そば・うどん' => 'ラーメン・つけ麺・そば・うどん',
            'お好み焼き・たこ焼き' => 'お好み焼き・たこ焼き',
            'ステーキ・ハンバーグ' => 'ステーキ・ハンバーグ',
            '韓国料理' => '韓国料理',
            '中華料理' => '中華料理',
            'イタリアン' => 'イタリアン',
            'カレー' => 'カレー',
            'アジア料理' => 'アジア料理',
            'ビュッフェ' => 'ビュッフェ',
            '居酒屋' => '居酒屋',
            '喫茶店' => '喫茶店',
            'スイーツ' => 'スイーツ',
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
        // 4. 店舗を作成
        // ==============================
        $stores = [
            [
                'name' => '山本屋本店',
                'description' => '名古屋味噌煮込みうどんの有名店。',
                'address' => '名古屋市中区栄3丁目',
                'image' => 'yamamotoya.jpg',
                'category' => '和食・定食',
                'recommend_flag' => true,
            ],
            [
                'name' => 'ラーメン一番',
                'description' => '地元で人気のラーメン店。',
                'address' => '名古屋市中村区名駅2丁目',
                'image' => 'ramen1.jpg',
                'category' => 'ラーメン・つけ麺・そば・うどん',
                'recommend_flag' => false,
            ],
            [
                'name' => '世界の山ちゃん',
                'description' => '名古屋名物手羽先で有名。',
                'address' => '名古屋市中区栄4丁目',
                'image' => 'yamachan.jpg',
                'category' => '居酒屋',
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
