<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        $categoryIds = [1, 2, 3, 4, 5]; // カテゴリID（後でSeederでカテゴリを作るならそのIDに合わせて調整）

        return [
            'name' => $this->faker->randomElement([
                '矢場とん 名古屋駅前店',
                'あつた蓬莱軒 本店',
                '世界の山ちゃん 錦店',
                '味仙 矢場町店',
                'コメダ珈琲 栄店',
                'スガキヤ 名駅地下街店',
                '山本屋本店 栄中央店',
                'カフェ ジャンシアーヌ JR名古屋駅',
                'コンパル 大須本店',
                '味噌煮込みうどん 山本屋総本家 本店',
            ]),
            'description' => $this->faker->realText(120, 2),
            'address' => '名古屋市' . $this->faker->citySuffix() . $this->faker->streetAddress(),
            'category_id' => $this->faker->randomElement($categoryIds),
            'image' => $this->faker->randomElement([
                'https://loremflickr.com/400/300/food,japan',
                'https://placehold.jp/400x300.png',
                'https://picsum.photos/400/300',
            ]),
            'recommend_flag' => $this->faker->boolean(30), // 30%の確率でおすすめ
        ];
    }
}
