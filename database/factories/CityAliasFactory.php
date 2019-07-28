<?php

use App\Models\City;
use App\Models\CityAlias;
use Faker\Generator as Faker;
use \Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(CityAlias::class, static function (Faker $faker) {
    return [
        'name'     => $faker->city,
        'city_id' => static function () {
            return factory(City::class)->create()->id;
        }
    ];
});
