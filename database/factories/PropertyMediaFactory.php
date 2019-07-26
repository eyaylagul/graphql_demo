<?php

use App\Enums\PropertyMediaType;
use App\Models\Property;
use App\Models\PropertyMedia;
use Faker\Generator as Faker;
use \Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(PropertyMedia::class, static function (Faker $faker) {
    return [
        'path'        => $faker->imageUrl(400, 300, 'cats', false),
        'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'is_local'    => false,
        'type'        => PropertyMediaType::IMG,
        'property_id' => static function () {
            return factory(Property::class)->create()->id;
        }
    ];
});
