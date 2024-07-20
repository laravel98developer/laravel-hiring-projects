<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::factory()->count(100)->create();
//        foreach ($user as $u){
//            $u->generate_token();
//        }
    }
}
