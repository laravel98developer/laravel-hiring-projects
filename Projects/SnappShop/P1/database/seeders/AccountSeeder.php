<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Account::create([
            'user_id' => '1',
            'account_number' => '1234567890',
            'balance' => '198045220'
        ]);
                
        Account::create([
            'user_id' => '1',
            'account_number' => '1122334455',
            'balance' => '4646548'
        ]);

        Account::create([
            'user_id' => '2',
            'account_number' => '3216549870',
            'balance' => '504202'
        ]);
    }
}
