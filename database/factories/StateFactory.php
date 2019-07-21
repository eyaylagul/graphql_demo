<?php

use App\Models\Country;
use App\Models\State;
use Faker\Generator as Faker;
use \Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(State::class, static function (Faker $faker) {
    return [
        'code'       => $faker->unique()->stateAbbr,
        'name'       => $faker->unique()->streetName,
        'country_id' => static function () {
            return factory(Country::class)->create()->id;
        }
    ];
});
