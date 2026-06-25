<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Carbon\Carbon;

class ResetProducts extends Command
{
    protected $signature = 'products:reset';
    protected $description = 'Reset product quantities at 5 AM daily';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting product reset...');

        $date = Carbon::today();
        $this->info('Current date: ' . $date); // Debug output

        $previousDay = Carbon::yesterday();
        $this->info('Previous day: ' . $previousDay); // Debug output

        $products = Product::where('date', $previousDay)->get();
        if ($products->isEmpty()) {
            $this->info('No products found for the previous day.');
        } else {
            foreach ($products as $product) {
                Product::create([
                    'name' => $product->name,
                    'on_hand' => 0,
                    'cooked' => 0,
                    'sold' => 0,
                    'wasted' => 0,
                    'category' => $product->category,
                    'expiration_duration' => $product->expiration_duration,
                    'date' => $date,
                ]);
                $this->info('Reset product: ' . $product->name); // Debug output
            }
        }

        $this->info('Product quantities have been reset.');
    }
}
