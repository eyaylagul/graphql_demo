<?php

use App\Models\Country;
use Faker\Generator as Faker;
use \Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Country::class, static function (Faker $faker) {
    return [
        'code' => $faker->unique()->stateAbbr,
        'name' => $faker->unique()->country
    ];
});
