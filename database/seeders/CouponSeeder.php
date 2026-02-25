<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            ['code' => 'BIENVENUE10', 'type' => 'percent', 'value' => 10, 'min_order' => 30, 'usage_limit' => 1000],
            ['code' => 'OFFRE15', 'type' => 'fixed', 'value' => 15, 'min_order' => 50, 'usage_limit' => 500],
            ['code' => 'LIVRAISONOFFERTE', 'type' => 'fixed', 'value' => 5.99, 'min_order' => 30, 'usage_limit' => null],
        ];

        foreach ($coupons as $data) {
            Coupon::updateOrCreate(
                ['code' => $data['code']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
