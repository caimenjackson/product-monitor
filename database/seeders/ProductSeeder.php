<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $today = Carbon::today()->format('Y-m-d');

        $products = [
            [
                'name' => 'O.R. Chicken',
                'expiration_duration' => 90, // 1 hour 30 minutes
                'date' => $today,
            ],
            [
                'name' => 'Fillets',
                'expiration_duration' => 60, // 1 hour
                'date' => $today,
            ],
            [
                'name' => 'Mini Fillets',
                'expiration_duration' => 45, // 45 minutes
                'date' => $today,
            ],
            [
                'name' => 'ISP Zinger',
                'expiration_duration' => 60, // 1 hour 30 minutes
                'date' => $today,
            ],
            [
                'name' => 'ISP Hotwing',
                'expiration_duration' => 90, // 1 hour 30 minutes
                'date' => $today,
            ],
            [
                'name' => 'FTF Bites',
                'expiration_duration' => 60, // 1 hour 30 minutes
                'date' => $today,
            ],
            [
                'name' => 'Hash Browns',
                'expiration_duration' => 30, // 30 minutes
                'date' => $today,
            ],
            [
                'name' => 'Popcorn',
                'expiration_duration' => 15, // 15 minutes
                'date' => $today,
                'category' => 'openfryers', // Set category to special
            ],
            [
                'name' => 'Rice',
                'expiration_duration' => 90, // 15 minutes
                'date' => $today,
            ],
            [
                'name' => 'Lettuce',
                'expiration_duration' => 180, // 15 minutes
                'date' => $today,
                'category' => 'special', // Set category to special
            ],
            [
                'name' => 'Apollo Lettuce',
                'expiration_duration' => 180, // 15 minutes
                'date' => $today,
                'category' => 'special', // Set category to special
            ],
            [
                'name' => 'Diced Tomatoes',
                'expiration_duration' => 180, // 15 minutes
                'date' => $today,
                'category' => 'special', // Set category to special
            ],
            [
                'name' => 'Cheese',
                'expiration_duration' => 180, // 15 minutes
                'date' => $today,
                'category' => 'special', // Set category to special
            ],
            [
                'name' => 'Pickled Slaw',
                'expiration_duration' => 180, // 15 minutes
                'date' => $today,
                'category' => 'special', // Set category to special
            ],
            [
                'name' => 'Tinned Sweetcorn',
                'expiration_duration' => 180, // 15 minutes
                'date' => $today,
                'category' => 'special', // Set category to special
            ],
            [
                'name' => 'Fries',
                'expiration_duration' => 5, // 15 minutes
                'date' => $today,
                'category' => 'openfryers', // Set category to special
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
