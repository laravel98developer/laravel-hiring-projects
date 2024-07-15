<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->firstOrCreate(["name" => "Personal"]);
        Category::query()->firstOrCreate(["name" => "Education"]);
        Category::query()->firstOrCreate(["name" => "Work"]);
        Category::query()->firstOrCreate(["name" => "Sport"]);
        Category::query()->firstOrCreate(["name" => "Shopping"]);
    }
}
