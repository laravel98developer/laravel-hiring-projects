<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $sourceUser = User::factory()->create(['phone' => '9149383467', 'name' => 'mehdi']);
        $destinationUser = User::factory()->create(['phone' => '9909856567', 'name' => 'reza']);

        User::All()->each(function ($user) {
            $user->accounts()->save(Account::factory()->make());
        });

        Account::all()->each(function ($account) {
            $account->cards()->saveMany(Card::factory()->count(2)->make(['balance' => 300000]));
        });
    }
}
