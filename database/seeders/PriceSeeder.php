<?php

namespace Database\Seeders;

use App\Price;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Price::create([
            'price' => 0.01,
        ]);
    }
}
