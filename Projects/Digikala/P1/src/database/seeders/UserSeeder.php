<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ناصر رمضانپور',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);
        User::factory(10)->create();
    }
}
