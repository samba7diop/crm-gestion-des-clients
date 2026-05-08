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
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Marketing User',
            'email' => 'marketing@example.com',
            'role' => 'marketing',
        ]);

        User::factory()->create([
            'name' => 'Commercial User',
            'email' => 'commercial@example.com',
            'role' => 'commercial',
        ]);

        User::factory()->create([
            'name' => 'Directeur Commercial',
            'email' => 'directeur@example.com',
            'role' => 'directeur_commercial',
        ]);

        User::factory()->create([
            'name' => 'Administration User',
            'email' => 'administration@example.com',
            'role' => 'administration',
        ]);
    }
}
