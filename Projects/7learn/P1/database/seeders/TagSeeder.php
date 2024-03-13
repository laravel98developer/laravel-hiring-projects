<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Tag;
use  App\Models\Category;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()->count(10)->create()
        ->each(function ($tag) {
            $categories = Category::inRandomOrder()->limit(rand(2, 8))->pluck("id");
            $tag->categories()->sync($categories);
        });
    }
}
