<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = Role::all()->pluck('id')->toArray();
        factory(User::class, 10)->create()->each(function ($user) use ($roles) {
            /** @var App\Models\User $user */
            // get random id
            $roleID = $roles[array_rand($roles, 1)];
            $user->syncRoles([$roleID]);
        });
    }
}
