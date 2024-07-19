<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BankAccount;
use App\Models\BankAccountCard;
use App\Models\Transaction;
use App\Models\TransactionWage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'test',
            'mobile' => '09123456789',
        ]);
        User::factory(10)->create();

        $users = User::all();
        foreach ($users as $user) {
            $BankAccount = BankAccount::factory()->for($user)->create();
            BankAccountCard::factory(2)
                ->for($user)
                ->for($BankAccount)
                ->create();
        }

        $bankAccountCards = BankAccountCard::pluck('id');

        for ($i = 0; $i < 100; $i++) {
            Transaction::factory()
                ->has(TransactionWage::factory())
                ->create([
                    'sender_card_id' => $bankAccountCards->random(),
                    'receiver_card_id' => $bankAccountCards->random(),
                ]);
        }
    }
}
