<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;

class PromoSeeder extends Seeder
{
    public function run()
    {
        Promo::create([
            'code' => 'DISKON20',
            'description' => 'Diskon 20% untuk semua menu',
            'type' => 'percentage',
            'value' => 20,
            'max_uses' => 100,
            'uses' => 0,
            'active' => true,
        ]);

        Promo::create([
            'code' => 'RP15000',
            'description' => 'Diskon Rp15.000 untuk pembelian minimum Rp100.000',
            'type' => 'fixed',
            'value' => 15000,
            'max_uses' => 50,
            'uses' => 0,
            'active' => true,
        ]);
    }
}
