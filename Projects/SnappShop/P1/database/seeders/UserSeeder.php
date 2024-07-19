<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'Pasha Ameri',
            'phone' => '09362267050',
        ]);

        User::create([
            'name' => 'Parsa Ahamdi',
            'phone' => '09305267050',
        ]);
    }
}
