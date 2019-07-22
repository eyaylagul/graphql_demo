<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() :void
    {
        DB::table('property_type')->insert([
            [
                'id'   => 1,
                'name' => 'Apartments',
                'description' => 'Apartments',
            ],
            [
                'id'   => 2,
                'name' => 'House',
                'description' => 'House',
            ],
            [
                'id'   => 3,
                'name' => 'Condo',
                'description' => 'Condo',
            ],
            [
                'id'   => 4,
                'name' => 'Duplex',
                'description' => 'Duplex',
            ],
            [
                'id'   => 5,
                'name' => 'Triplex',
                'description' => 'Triplex',
            ],
            [
                'id'   => 6,
                'name' => '4plex',
                'description' => '4plex',
            ],
            [
                'id'   => 7,
                'name' => 'Senior',
                'description' => 'Senior Housing',
            ],
            [
                'id'   => 8,
                'name' => 'AssistedLiving',
                'description' => 'Assisted Living',
            ],
            [
                'id'   => 9,
                'name' => 'Subsidized',
                'description' => 'Subsidized',
            ],
            [
                'id'   => 10,
                'name' => 'GardenStyle',
                'description' => 'Garden Style (1-4 stories)',
            ],
            [
                'id'   => 11,
                'name' => 'MidRise',
                'description' => 'Mid Rise (5-8 stories)',
            ],
            [
                'id'   => 12,
                'name' => 'Townhouse',
                'description' => 'Townhome',
            ],
            [
                'id'   => 13,
                'name' => 'Flat',
                'description' => 'Flat',
            ],
            [
                'id'   => 14,
                'name' => 'Cooperative',
                'description' => 'Cooperative',
            ],
            [
                'id'   => 15,
                'name' => 'CorporateSuite',
                'description' => 'Corporate Suite',
            ],
            [
                'id'   => 16,
                'name' => 'HighRise',
                'description' => 'High Rise (9+ stories)',
            ],
            [
                'id'   => 17,
                'name' => 'Mobile',
                'description' => 'Mobile Home',
            ],
            [
                'id'   => 18,
                'name' => 'SpecialNeeds',
                'description' => 'Special Needs Housing',
            ],
            [
                'id'   => 19,
                'name' => 'Room For Rent',
                'description' => 'Room For Rent',
            ],
            [
                'id'   => 20,
                'name' => 'Basement',
                'description' => 'Basement',
            ],
        ]);
    }
}
