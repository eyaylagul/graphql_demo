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
    public function run()
    {
        DB::table('country')->insert([
            [
                'id'   => 1,
                'code' => 'CA',
                'name' => 'Canada',
            ],
            [
                'id'   => 2,
                'code' => 'US',
                'name' => 'United States',
            ],
        ]);
    }
}
