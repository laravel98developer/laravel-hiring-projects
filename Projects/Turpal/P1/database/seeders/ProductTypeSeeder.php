<?php

namespace Database\Seeders;

use App\Constants\ProductTypeConstant;
use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $types = ProductTypeConstant::getTypes();
        foreach ($types as $type){
            ProductType::query()->firstOrCreate([
                'type' => $type
            ]);
        }
    }
}
