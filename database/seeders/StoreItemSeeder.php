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
                'is_active' => true,
            ],
            [
                'item_name' => '5 Lives',
                'item_type' => 'Lives',
                'item_price' => 90,
                'lives_amount' => 5,
                'is_active' => true,
            ],
            [
                'item_name' => 'Dragon Mascot',
                'item_type' => 'Mascot',
                'item_price' => 100,
                'lives_amount' => null,
                'is_active' => true,
            ],
            [
                'item_name' => 'Cat Mascot',
                'item_type' => 'Mascot',
                'item_price' => 120,
                'lives_amount' => null,
                'is_active' => true,
            ],
        ]);
    }
}
