<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => '味噌カツ'],
            ['id' => 2, 'name' => 'ひつまぶし'],
            ['id' => 3, 'name' => '手羽先'],
            ['id' => 4, 'name' => 'きしめん'],
            ['id' => 5, 'name' => '喫茶店モーニング'],
        ]);
    }
}
