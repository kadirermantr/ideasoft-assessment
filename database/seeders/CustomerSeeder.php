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
        $jsonFile = database_path('files/customers.json');
        $customers = json_decode(file_get_contents($jsonFile), true);

        Customer::insert($customers);
    }
}
