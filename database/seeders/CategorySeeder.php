<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /** Catégories sans image par défaut — uniquement les images que vous fournissez. */
    public function run(): void
    {
        $categories = [
            ['name' => 'Lèvres', 'slug' => 'levres', 'description' => 'Rouges à lèvres, gloss, pencils et soins des lèvres', 'sort_order' => 1, 'image' => 'images/products/levres-1.png'],
            ['name' => 'Teint', 'slug' => 'teint', 'description' => 'Fond de teint, correcteurs, poudres et bases', 'sort_order' => 2, 'image' => 'images/products/teint-1.png'],
            ['name' => 'Yeux', 'slug' => 'yeux', 'description' => 'Fards à paupières, mascaras, eyeliners et sourcils', 'sort_order' => 3, 'image' => 'images/products/yeux-1.png'],
            ['name' => 'Ongles', 'slug' => 'ongles', 'description' => 'Vernis, soins et accessoires pour les ongles', 'sort_order' => 4, 'image' => 'images/products/ongles-1.png'],
            ['name' => 'Soins', 'slug' => 'soins', 'description' => 'Crèmes, sérums et routines beauté', 'sort_order' => 5, 'image' => 'images/products/soin-1.png'],
            ['name' => 'Accessoires', 'slug' => 'accessoires', 'description' => 'Pinceaux, éponges et trousses de maquillage', 'sort_order' => 6, 'image' => 'images/products/acces-1.png'],
        ];

        foreach ($categories as $data) {
            $image = $data['image'] ?? null;
            unset($data['image']);
            Category::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['is_active' => true, 'image' => $image])
            );
        }
    }
}
