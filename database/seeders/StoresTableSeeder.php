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
        // 名古屋グルメ用カテゴリを作成（存在しなければ自動作成）
        $ramenCategory = Category::firstOrCreate(
            ['name' => 'ラーメン'],
            [
                'description' => 'ラーメン',
                'major_category_id' => 1, // 適宜設定
            ]
        );

        $misoKatsuCategory = Category::firstOrCreate(
            ['name' => '味噌カツ'],
            [
                'description' => '味噌カツ',
                'major_category_id' => 1,
            ]
        );

        $tebasakiCategory = Category::firstOrCreate(
            ['name' => '手羽先'],
            [
                'description' => '手羽先',
                'major_category_id' => 1,
            ]
        );

        // サンプル店舗を作成
        Store::create([
            'name' => '山本屋本店',
            'description' => '名古屋味噌煮込みうどんの有名店。',
            'address' => '名古屋市中区栄3丁目',
            'image' => 'yamamotoya.jpg',
            'category_id' => $misoKatsuCategory->id,
            'recommend_flag' => true,
        ]);

        Store::create([
            'name' => 'ラーメン一番',
            'description' => '地元で人気のラーメン店。',
            'address' => '名古屋市中村区名駅2丁目',
            'image' => 'ramen1.jpg',
            'category_id' => $ramenCategory->id,
            'recommend_flag' => false,
        ]);

        Store::create([
            'name' => '世界の山ちゃん',
            'description' => '名古屋名物手羽先で有名。',
            'address' => '名古屋市中区栄4丁目',
            'image' => 'yamachan.jpg',
            'category_id' => $tebasakiCategory->id,
            'recommend_flag' => true,
        ]);
    }
}
