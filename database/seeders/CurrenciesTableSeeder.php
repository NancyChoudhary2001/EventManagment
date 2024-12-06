<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['currency' => 'USD'],
            ['currency' => 'EUR'],
            ['currency' => 'GBP'],
            ['currency' => 'INR'],
            ['currency' => 'JPY'],
            ['currency' => 'AUD'],
            ['currency' => 'CAD'],
            ['currency' => 'CNY'],
            ['currency' => 'CHF'],
            ['currency' => 'NZD'],
        ];

        DB::table('currencies')->insert($currencies);
    }
}
