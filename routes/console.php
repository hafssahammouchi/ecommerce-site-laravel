<?php

use App\Models\Product;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('products:remove-old', function () {
    $slugs = [
        'rouge-levres-mat-velvet',
        'fond-de-teint-fluide-24h',
        'palette-yeux-12-nuances',
        'mascara-volume-intense',
        'eyeliner-liquide-waterproof',
    ];
    $deleted = Product::whereIn('slug', $slugs)->delete();
    $this->info("Produits supprimés du site : {$deleted}");
})->purpose('Supprime immédiatement les anciens produits (rouge mat velvet, fond de teint fluide, anciens yeux)');
