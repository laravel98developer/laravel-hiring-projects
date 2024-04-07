<?php

namespace Database\Seeders;

use App\Models\DeliveryRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $origin_latitude = 12.5;
        $origin_longitude = 13;
        $origin_firstname = 'Mohammad Javad';
        $origin_lastname = 'Mehrabi';
        $origin_address = 'Isfahan';
        $origin_phone = '989336223710';
        $destination_latitude = 22.3;
        $destination_longitude = 53;
        $destination_firstname = 'Reza';
        $destination_lastname = 'Keramati';
        $destination_address = 'Tehran';
        $destination_phone = '989126223710';
        $collection_user_id = 2;
        DeliveryRequest::insert([
            compact('origin_latitude', 'origin_longitude', 'origin_firstname', 'origin_lastname', 'origin_address', 'origin_phone', 'destination_latitude', 'destination_longitude', 'destination_firstname', 'destination_lastname', 'destination_address', 'destination_phone', 'collection_user_id')
        ]);
    }
}
