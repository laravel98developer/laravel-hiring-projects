<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(6)->sequence(
            ['role' => Role::ADMIN->value],
            ['role' => Role::COLLECTION->value],
            ['role' => Role::DELIVERER->value]
        )->create();
    }
}
