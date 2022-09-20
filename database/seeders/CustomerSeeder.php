<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
          [
              'name' => 'Türker Jöntürk',
              'revenue' => 492.12,
              'since' => '2014-06-28',
          ],
          [
              'name' => 'Kaptan Devopuz',
              'revenue' => 1505.95,
              'since' => '2015-01-15',
          ],
          [
              'name' => 'İsa Sonuyumaz',
              'revenue' => 0,
              'since' => '2016-02-11',
          ],
        ];

        Customer::insert($customers);
    }
}
