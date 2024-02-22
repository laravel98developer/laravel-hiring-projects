<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wallet::query()->insert([
            [
                'user_id' => 1,
                'balance' => 0,
                'created_at' => Carbon::now(),
            ], [
                'user_id' => 2,
                'balance' => 0,
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
