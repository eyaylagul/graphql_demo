<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() :void
    {
        DB::table('country')->insert([
            [
                'code' => 'CA',
                'name' => 'Canada',
            ],
            [
                'code' => 'US',
                'name' => 'United States',
            ],
        ]);
    }
}
