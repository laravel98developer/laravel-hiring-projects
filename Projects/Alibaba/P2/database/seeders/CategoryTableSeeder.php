<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Lorem ipsum1',
        ]);

        Category::create([
            'name' => 'Lorem ipsum2',
        ]);

        Category::create([
            'name' => 'Lorem ipsum3',
        ]);
    }
}
