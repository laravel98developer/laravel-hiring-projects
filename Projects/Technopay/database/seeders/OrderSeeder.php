<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::query()->insert([
            'mobile_number' => '09121111111',
            'national_code' => '0000000000',
            'amount'        => 500000,
            'status'        => true,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}
