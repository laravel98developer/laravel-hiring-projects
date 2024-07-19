<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Card::create([
            'account_id' => '1',
            'card_number' => '6219861922701437'
        ]);

        Card::create([
            'account_id' => '2',
            'card_number' => '4321432143214321'
        ]);

        Card::create([
            'account_id' => '3',
            'card_number' => '6362141124764441'
        ]);
    }
}
