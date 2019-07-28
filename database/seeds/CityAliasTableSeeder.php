<?php

use App\Models\CityAlias;
use Illuminate\Database\Seeder;

class CityAliasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() :void
    {
        factory(CityAlias::class, 5)->create();
    }
}
