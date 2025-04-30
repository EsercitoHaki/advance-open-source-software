<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('store_items')->insert([
            [
                'item_name' => '1 Lives',
                'item_type' => 'Lives',
                'item_price' => 20,
                'lives_amount' => 1,
                'mascot_pic' => null,
            ],
            [
                'item_name' => '5 Lives',
                'item_type' => 'Lives',
                'item_price' => 90,
                'lives_amount' => 5,
                'mascot_pic' => null,
            ],
            [
                'item_name' => 'Dragon Mascot',
                'item_type' => 'Mascot',
                'item_price' => 100,
                'lives_amount' => null,
                'mascot_pic' => 'dragon.png',
            ],
            [
                'item_name' => 'Cat Mascot',
                'item_type' => 'Mascot',
                'item_price' => 120,
                'lives_amount' => null,
                'mascot_pic' => 'cat.png',
            ],
        ]);
    }
}
