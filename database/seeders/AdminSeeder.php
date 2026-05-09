<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'first_name' => 'علی اکبر',
            'last_name' => 'خانی',
            'national_code' => '1234567890',
            'phone' => '09123456789',
            'password' => '123456', // ساده
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
