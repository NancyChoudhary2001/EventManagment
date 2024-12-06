<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = DB::table('states')->get();

        foreach ($states as $state) {
            
            $cities = [];

            switch ($state->name) {
                case 'Andhra Pradesh':
                    $cities = ['Hyderabad', 'Vijayawada', 'Visakhapatnam'];
                    break;
                case 'Arunachal Pradesh':
                    $cities = ['Itanagar', 'Tawang', 'Ziro'];
                    break;
                case 'Assam':
                    $cities = ['Guwahati', 'Jorhat', 'Dibrugarh'];
                    break;
                case 'Bihar':
                    $cities = ['Patna', 'Gaya', 'Bhagalpur'];
                    break;
                case 'Chhattisgarh':
                    $cities = ['Raipur', 'Bilaspur', 'Durg'];
                    break;
                case 'Goa':
                    $cities = ['Panaji', 'Margao', 'Vasco da Gama'];
                    break;
                case 'Jammu and Kashmir':
                    $cities = ['Jammu', 'Srinagar', 'Samba'];
                    break;
                case 'Delhi':
                    $cities = ['Mehrauli', 'New Delhi', 'Firozabad'];
                    break;
                default:
                    $cities = [];
            }

            
            foreach ($cities as $city) {
                DB::table('cities')->insert([
                    'name' => $city,
                    'state_id' => $state->id,  
                ]);
            }
        }
    }
}
