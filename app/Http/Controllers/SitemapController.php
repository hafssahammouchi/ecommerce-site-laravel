<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $base = url('/');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= '<url><loc>' . $base . '</loc><changefreq>daily</changefreq><priority>1</priority></url>' . "\n";
        $xml .= '<url><loc>' . $base . '/boutique</loc><changefreq>daily</changefreq><priority>0.9</priority></url>' . "\n";

        Category::active()->get()->each(function ($c) use (&$xml, $base) {
            $xml .= '<url><loc>' . $base . '/boutique/categorie/' . e($c->slug) . '</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>' . "\n";
        });
        Product::active()->get()->each(function ($p) use (&$xml, $base) {
            $xml .= '<url><loc>' . $base . '/boutique/produit/' . e($p->slug) . '</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>' . "\n";
        });

        $xml .= '</urlset>';
        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
