<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Conseil personnalisé', 'slug' => 'conseil-personnalise', 'description' => 'Un expert vous aide à choisir les produits adaptés à votre teint et à votre style.', 'price' => 0, 'icon' => 'bi-person-check', 'sort_order' => 1],
            ['name' => 'Échantillons offerts', 'slug' => 'echantillons-offerts', 'description' => 'Recevez des échantillons dans chaque commande pour découvrir nos nouveautés.', 'price' => 0, 'icon' => 'bi-gift', 'sort_order' => 2],
            ['name' => 'Retours gratuits 30 jours', 'slug' => 'retours-gratuits', 'description' => 'Insatisfaite ? Retournez votre produit sous 30 jours, sans frais.', 'price' => 0, 'icon' => 'bi-arrow-return-left', 'sort_order' => 3],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['is_active' => true, 'content' => 'Service dédié à votre satisfaction.'])
            );
        }
    }
}
