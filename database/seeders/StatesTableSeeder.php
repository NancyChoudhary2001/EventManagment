<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $india = DB::table('countries')->where('name', 'India')->first();

        $states = [
            'Andhra Pradesh',
            'Arunachal Pradesh',
            'Assam',
            'Bihar',
            'Chhattisgarh',
            'Goa',
            'Gujarat',
            'Haryana',
            'Himachal Pradesh',
            'Jharkhand',
            'Karnataka',
            'Kerala',
            'Madhya Pradesh',
            'Maharashtra',
            'Manipur',
            'Meghalaya',
            'Mizoram',
            'Nagaland',
            'Odisha',
            'Punjab',
            'Rajasthan',
            'Sikkim',
            'Tamil Nadu',
            'Telangana',
            'Tripura',
            'Uttar Pradesh',
            'Uttarakhand',
            'West Bengal',
            'Andaman and Nicobar Islands',
            'Chandigarh',
            'Dadra and Nagar Haveli and Daman and Diu',
            'Lakshadweep',
            'Delhi',
            'Puducherry',
            'Jammu and Kashmir',
            'Ladakh',
        ];

        foreach ($states as $state) {
            DB::table('states')->insert([
                'name' => $state,
                'country_id' => $india->id,  
            ]);
        }
    }
}
