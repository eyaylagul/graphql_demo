<?php

use App\Models\PropertyType;
use Faker\Generator as Faker;
use  Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(PropertyType::class, static function (Faker $faker) {
    return [
        'name'       => $faker->unique()->word,
        'description' => $faker->text(100)
    ];
});
