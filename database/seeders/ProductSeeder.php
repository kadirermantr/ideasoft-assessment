<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = database_path('files/products.json');
        $products = json_decode(file_get_contents($jsonFile), true);

        Product::insert($products);
    }
}
