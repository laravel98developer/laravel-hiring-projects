<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->insert([
            [
                'name' => 'Farshad',
                'phone' => '09111111111',
                'created_at' => Carbon::now(),
            ], [
                'name' => 'Test',
                'phone' => '09222222222',
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
