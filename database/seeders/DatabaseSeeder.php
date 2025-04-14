<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Vérifier si l'email existe déjà
        if (!User::where('email', 'amid.mohamed2024@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Mohamed Amid',
                'email' => 'amid.mohamed2024@gmail.com',
            ]);
        }
    }
}
