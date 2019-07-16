<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CreateUser extends Command
{
    protected $signature = 'create:user';

    protected $description = 'Implements a user creation';

    public function handle(): void
    {
        $this->info('Input user information:');

        $firstName = $this->ask('First name');
        $lastName  = $this->ask('Last name');
        $email     = $this->ask('Email');
        $password  = $this->secret('password');

        $roles    = Role::all()->pluck('name', 'id')->toArray();
        $roleName = $this->choice('Select role:', $roles);

        $countries = Country::all()->pluck('name', 'id')->toArray();
        $countryName = $this->choice('Select country:', $countries);
        $countryID = array_search($countryName, $countries, true);

        $states = State::where('country_id', '=', $countryID)->pluck('name', 'id')->toArray();
        $stateName = $this->choice('Select state:', $states);
        $stateID = array_search($stateName, $states, true);

        $cities = City::where('state_id', '=', $stateID)->pluck('name', 'id')->toArray();
        $cityName = $this->choice('Select city:', $cities);
        $cityID = array_search($cityName, $cities, true);

        $user             = new User();
        $user->first_name = $firstName;
        $user->last_name  = $lastName;
        $user->email      = $email;
        $user->password   = $password;
        $user->city_id    = $cityID;
        $user->save();

        $role = Role::findOrFail(array_search($roleName, $roles, true));
        $user->attachRole($role);

        $this->info('User created');
    }
}
