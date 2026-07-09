<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'email' => 'superadmin@example.com',
            'role' => 'superadmin',
            'is_active' => true,
            'failed_attempts' => 0,
            'lockout_multiplier' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
