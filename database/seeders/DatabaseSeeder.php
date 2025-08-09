<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Container\Attributes\Database;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            UsersSeeder::class,
            DepartementSeeder::class,
            StudentSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
