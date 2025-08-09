<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'email_verified_at' => Carbon::now(),
                'role_id' => 1,
            ],
            [
                'name' => 'Ach. Faishul Lisan',
                'email' => 'fasihullisan091966@gmail.com',
                'password' => bcrypt('fasih123'),
                'email_verified_at' => Carbon::now(),
                'role_id' => 2,
            ],
        ]);
    }
}
