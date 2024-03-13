<?php

namespace Database\Seeders;

use App\Models\BankInfo;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PublishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'firstname' => 'Panel',
                'lastname' => 'Admin',
                'email' => 'admin@email.com',
                'password' => Hash::make('admin'),
            ],
            [
                'firstname' => 'یوزر',
                'lastname' => 'تستی',
                'email' => 'testuser@email.com',
                'password' => Hash::make('testpassword'),
            ]
        ]);


        BankInfo::create([
            'user_id' => 1,
            'card_number' => '5022291307776391',
            'bank_name' => 'ملت',
            'sheba' => 'IRcsd64651654646565',
        ]);

        Product::factory(5)->create();
    }
}
