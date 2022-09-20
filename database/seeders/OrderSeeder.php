<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = database_path('files/orders.json');
        $orders = json_decode(file_get_contents($jsonFile), true);

        Order::insert($orders);
    }
}
