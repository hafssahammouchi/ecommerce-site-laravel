<?php

return [
    'name' => env('SHOP_NAME', 'Glow Beauty'),

    'currency' => 'EUR',
    'currency_symbol' => '€',

    'free_shipping_threshold' => (float) env('SHOP_FREE_SHIPPING_THRESHOLD', 50),

    'shipping' => [
        'standard' => [
            'label' => 'Livraison standard (5-7 jours)',
            'price' => 5.99,
        ],
        'express' => [
            'label' => 'Express (24-48h)',
            'price' => 9.99,
        ],
        'relay' => [
            'label' => 'Point relais (4-6 jours)',
            'price' => 4.99,
        ],
    ],

    'order' => [
        'default_status' => 'pending',
        'paid_status' => 'paid',
        'shipped_status' => 'shipped',
        'delivered_status' => 'delivered',
    ],

    'reviews' => [
        'require_approval' => true,
        'allow_guest' => false,
    ],

    'slider' => [],

    /* Image de fond du hero page d'accueil (quand le slider est vide). Chemin relatif à public/. */
    'hero_background' => 'images/products/soin-4.png',
];
