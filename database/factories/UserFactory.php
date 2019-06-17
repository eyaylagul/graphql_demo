<?php

use App\Models\City;
use Faker\Generator as Faker;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$cities = City::all()->pluck('id')->toArray();
$factory->define(User::class, function (Faker $faker) use ($cities) {
    return [
        'first_name'        => $faker->firstName,
        'last_name'         => $faker->lastName,
        'notify'            => $faker->randomElement([0, 1]),
        'phone'             => generateMultipleTimes($faker, 'tollFreePhoneNumber'),
        'address'           => generateMultipleTimes($faker, 'streetAddress'),
        'status'            => $faker->randomElement(['available', 'blocked']),
        'city_id'           => $faker->randomElement($cities),
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => str_random(10),
        'remember_token'    => str_random(10),
    ];
});

function generateMultipleTimes(Faker $faker, string $property): array
{
    $genAmount = random_int(1, 3);
    for ($i = 0; $i < $genAmount; $i++) {
        $address[] = $faker->$property;
    }

    return $address;
}
