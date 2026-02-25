<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin par défaut
        User::factory()->admin()->create([
            'name' => 'Administrateur',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Utilisateur de test
        User::factory()->create([
            'name' => 'Utilisateur Test',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        // Données de démo (catégories, produits, services)
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            CouponSeeder::class,
        ]);
    }
}
