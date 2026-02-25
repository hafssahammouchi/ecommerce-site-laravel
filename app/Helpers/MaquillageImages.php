<?php

namespace App\Helpers;

/**
 * URLs d'images Unsplash 100% maquillage / beauté — thème cohérent par catégorie.
 * Format: https://images.unsplash.com/photo-{id}?w={width}&q=80
 */
final class MaquillageImages
{
    private const BASE = 'https://images.unsplash.com/photo-';

    /** Images par catégorie (lèvres, teint, yeux, ongles, soins, accessoires) — maquillage uniquement. */
    public const BY_CATEGORY = [
        'levres' => '1596462502278-27bfdc403348',       // rouge à lèvres
        'teint'  => '1612817159949-195b6eb9e31a',      // fond de teint / cosmétiques
        'yeux'   => '1631214524026-7d4a6f448438',      // mascara / regard
        'ongles' => '1604654894610-df63bc536371',      // vernis à ongles
        'soins'  => '1571781926291-c477ebfd024b',      // soin visage / sérum
        'accessoires' => '1596755389378-c31d21fd1273', // pinceaux maquillage
    ];

    /** Plusieurs images maquillage par catégorie pour varier les produits (toutes thématique maquillage). */
    public const BY_CATEGORY_POOL = [
        'levres' => ['1596462502278-27bfdc403348', '1586495777744-4413f21062fa', '1596462502278-27bfdc403348'],
        'teint'  => ['1612817159949-195b6eb9e31a', '1522335789203-aabd1fc54bc9', '1612817159949-195b6eb9e31a'],
        'yeux'   => ['1631214524026-7d4a6f448438', '1487412947147-5cebf100ffc2', '1620916566398-39f1143ab7be'],
        'ongles' => ['1604654894610-df63bc536371', '1512496015851-a90fb38ba796', '1604654894610-df63bc536371'],
        'soins'  => ['1571781926291-c477ebfd024b', '1612817159949-195b6eb9e31a', '1571781926291-c477ebfd024b'],
        'accessoires' => ['1596755389378-c31d21fd1273', '1522335789203-aabd1fc54bc9', '1596755389378-c31d21fd1273'],
    ];

    public static function category(string $slug, int $width = 600): string
    {
        $id = self::BY_CATEGORY[$slug] ?? self::BY_CATEGORY['levres'];
        return self::BASE . $id . '?w=' . $width . '&q=80';
    }

    public static function product(string $categorySlug, int $index, int $width = 800): string
    {
        $pool = self::BY_CATEGORY_POOL[$categorySlug] ?? self::BY_CATEGORY_POOL['levres'];
        $id = $pool[$index % count($pool)];
        return self::BASE . $id . '?w=' . $width . '&q=80';
    }

    /** Hero accueil — maquillage. */
    public static function hero(int $width = 800): string
    {
        return self::BASE . '1522335789203-aabd1fc54bc9?w=' . $width . '&q=80';
    }
}
