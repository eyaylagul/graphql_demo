<?php

use App\Models\User;
use App\Models\City;
use App\Models\Property;
use App\Enums\PropertyStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$cities       = City::all()->pluck('id')->toArray();
$users        = User::all()->pluck('id')->toArray();
$propertyType = User::all()->pluck('id')->toArray();
$factory->define(Property::class, static function (Faker $faker) use ($users, $cities, $propertyType) {
    return [
        'status'           => $faker->randomElement(PropertyStatus::getKeys()),
        'expire_at'        => $faker->dateTime(),
        'available_at'     => $faker->dateTime(),
        'title'            => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description'      => $faker->realText($maxNbChars = 2000, $indexSize = 2),
        'price'            => $faker->numberBetween(500, 5000),
        'price_max'        => $faker->numberBetween(5000, 9000),
        'address'          => $faker->streetAddress,
        'postcode'         => $faker->postcode,
        'square_feet'      => $faker->numberBetween(100, 1000),
        'pets'             => $faker->boolean(),
        'bedrooms'         => $faker->randomDigitNotNull(),
        'bathrooms'        => $faker->randomFloat(2, 0, 9),
        'lat'              => $faker->latitude,
        'lng'              => $faker->longitude,
        'property_type_id' => $faker->randomElement($propertyType),
        'user_id'          => $faker->randomElement($users),
        'city_id'          => $faker->randomElement($cities)
    ];
});
