<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'huce.english.learning.lab@gmail.com'],
            [
                'user_id' => Str::uuid(),
                'username' => 'admin',
                'password' => Hash::make('Admin123'),
                'role_id' => 1,
                'is_active' => true,
                'registration_date' => now(),
                'full_name' => 'Quản Trị Viên',
                'gender' => 'other',
                'avatar' => 'default-avatar.png',
                'coins' => 0,
                'lives' => 5,
                'current_streak' => 0,
                'longest_streak' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}