<?php

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyMedia;

class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() :void
    {
        factory(Property::class, 5)->create()
            ->each(static function ($property, $key) {
                $media = factory(PropertyMedia::class)->make();
                $media->position = $key;
                $media->is_primary = $key == 0 ? true : false;
                $media->property_id = $property->id;
                $media->save();
            });
    }
}
