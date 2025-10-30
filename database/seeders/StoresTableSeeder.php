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
        // 例：カテゴリを先に取得（存在する前提）
        $ramenCategory = Category::where('name', 'ラーメン')->first();
        $misoKatsuCategory = Category::where('name', '味噌カツ')->first();

        // サンプル店舗を作成
        Store::create([
            'name' => '山本屋本店',
            'description' => '名古屋味噌煮込みうどんの有名店。',
            'address' => '名古屋市中区栄3丁目',
            'image' => 'yamamotoya.jpg',
            'category_id' => $misoKatsuCategory->id ?? 1, // カテゴリが見つからなければ1
            'recommend_flag' => true,
        ]);

        Store::create([
            'name' => 'ラーメン一番',
            'description' => '地元で人気のラーメン店。',
            'address' => '名古屋市中村区名駅2丁目',
            'image' => 'ramen1.jpg',
            'category_id' => $ramenCategory->id ?? 1,
            'recommend_flag' => false,
        ]);

        // 必要に応じてさらに追加可能
    }
}
