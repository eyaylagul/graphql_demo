<?php

use App\Models\State;
use App\Models\City;
use Faker\Generator as Faker;
use \Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(City::class, static function (Faker $faker) {
    return [
        'lat'      => round($faker->latitude, 4),
        'lng'      => round($faker->longitude, 4),
        'name'     => $faker->city,
        'state_id' => static function () {
            return factory(State::class)->create()->id;
        }
    ];
});
