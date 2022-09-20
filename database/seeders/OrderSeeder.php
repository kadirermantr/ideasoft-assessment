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
        $orders = [
            [
                'customerId' => 1,
                'items' => json_encode([
                    [
                        'productId'=> 3,
                        'quantity' => 10,
                        'unitPrice' => 11.28,
                        'total' => 112.80,
                    ],
                ]),
                'total' => 112.80,
            ],
            [
                'customerId' => 2,
                'items' => json_encode([
                    [
                        'productId'=> 2,
                        'quantity' => 2,
                        'unitPrice' => 49.50,
                        'total' => 99,
                    ],
                    [
                        'productId'=> 1,
                        'quantity' => 1,
                        'unitPrice' => 120.75,
                        'total' => 120.75,
                    ],
                ]),
                'total' => 219.75,
            ],
            [
                'customerId' => 3,
                'items' => json_encode([
                    [
                        'productId'=> 3,
                        'quantity' => 6,
                        'unitPrice' => 11.28,
                        'total' => 67.68,
                    ],
                    [
                        'productId'=> 1,
                        'quantity' => 10,
                        'unitPrice' => 120.75,
                        'total' => 1207.5,
                    ],
                ]),
                'total' => 1275.18,
            ],
        ];

        Order::insert($orders);
    }
}
