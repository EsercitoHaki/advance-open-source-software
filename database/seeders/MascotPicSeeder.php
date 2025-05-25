<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MascotPicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mascot_pics')->insert([
            [
                'mascot_id' => 4,
                'pic_name' => 'Cat Mascot 1',
                'pic_url' => 'public/images/mascot/cat/cat_mascot_1.jpg',
            ],
            [
                'mascot_id' => 4,
                'pic_name' => 'Cat Mascot 2',
                'pic_url' => 'public/images/mascot/cat/cat_mascot_2.jpg',
            ],
            [
                'mascot_id' => 4,
                'pic_name' => 'Cat Mascot 3',
                'pic_url' => 'public/images/mascot/cat/cat_mascot_3.jpg',
            ],
            [
                'mascot_id' => 4,
                'pic_name' => 'Cat Mascot 4',
                'pic_url' => 'public/images/mascot/cat/cat_mascot.png',
            ],
        ]);
    }
}
