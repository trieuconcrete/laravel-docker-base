<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Note: UserSeeder includes Plans seeding via migration
        // Run migrations first: php artisan migrate:fresh --seed
        $this->call([
            UserSeeder::class,
        ]);
    }
}
