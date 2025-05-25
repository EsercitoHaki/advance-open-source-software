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
                'item_name' => 'Ant',
                'item_type' => 'Mascot',
                'item_price' => 100,
                'lives_amount' => null,
                'is_active' => true,
            ],
            [
                'item_name' => 'Cockroach',
                'item_type' => 'Mascot',
                'item_price' => 100,
                'lives_amount' => null,
                'is_active' => true,
            ],
            [
                'item_name' => 'Corgi',
                'item_type' => 'Mascot',
                'item_price' => 100,
                'lives_amount' => null,
                'is_active' => true,
            ],
            [
                'item_name' => 'Lion',
                'item_type' => 'Mascot',
                'item_price' => 100,
                'lives_amount' => null,
                'is_active' => true,
            ],
            [
                'item_name' => 'Panda',
                'item_type' => 'Mascot',
                'item_price' => 100,
                'lives_amount' => null,
                'is_active' => true,
            ],
            [
                'item_name' => 'Snake',
                'item_type' => 'Mascot',
                'item_price' => 100,
                'lives_amount' => null,
                'is_active' => true,
            ],
            [
                'item_name' => 'Squirrel',
                'item_type' => 'Mascot',
                'item_price' => 100,
                'lives_amount' => null,
                'is_active' => true,
            ],
        ]);
    }
}
