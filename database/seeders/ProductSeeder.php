<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 10000;
        $totalRecords = 1000000;
        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            Product::factory()->count($batchSize)->create();
        }
    }
}
