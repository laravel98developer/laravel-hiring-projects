<?php

namespace Database\Seeders;

use App\Models\GiftCode;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GiftCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GiftCode::query()->insert([
            'code' => env('GIFT_CODE'),
            'price' => env('GIFT_CODE_PRICE'),
            'created_at' => Carbon::now(),
        ]);
    }
}
