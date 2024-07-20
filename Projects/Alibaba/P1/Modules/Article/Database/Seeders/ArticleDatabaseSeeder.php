<?php

namespace Modules\Article\Database\Seeders;

use Illuminate\Database\Seeder;

class ArticleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $this->call(ArticleSeeder::class);
    }
}
