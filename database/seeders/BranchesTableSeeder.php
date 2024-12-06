<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Define specific data for cities and their branches
         $data = [
            [
                'city_id' => 22,
                'branches' => [
                    ['name' => 'Jammu Branch'],
                    ['name' => 'Udhampur Branch'],
                ],
            ],
            [
                'city_id' => 23, // City ID 2
                'branches' => [
                    ['name' => 'Anantnag Branch'],
                    ['name' => 'Shopian Branch'],
                    ['name' => 'Kulgam Branch'],
                ],
            ],
            [
                'city_id' => 10, // City ID 3
                'branches' => [
                    ['name' => 'Patna Branch'],
                ],
            ],
        ];

        
        foreach ($data as $city) {
            foreach ($city['branches'] as $branch) {
                DB::table('branches')->insert([
                    'city_id' => $city['city_id'],
                    'name' => $branch['name'],
                ]);
            }
        }
    }
}
