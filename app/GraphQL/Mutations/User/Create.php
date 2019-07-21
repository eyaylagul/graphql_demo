<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use App\Models\Role;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use App\Traits\GraphQLAuth;

class Create extends Mutation
{
    use GraphQLAuth;

    protected $permission = 'user.create';

    public function type()
    {
        return GraphQL::type('Users');
    }

    // todo some rules repeated need to find out better solution to avoid it
    public function rules(array $args = []): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|max:255|email|unique:user,email',
            'password'   => 'required|string|min:8',
            'role_id'    => 'required|exists:role,id',
            'city_id'    => 'nullable|exists:city,id',
            'phone.*'    => 'nullable|numeric'
        ];
    }

    public function args(): array
    {
        return [
            'email'      => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
            ],
            'first_name' => [
                'name' => 'first_name',
                'type' => Type::nonNull(Type::string()),
            ],
            'last_name'  => [
                'name' => 'last_name',
                'type' => Type::nonNull(Type::string()),
            ],
            'password'   => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string())
            ],
            'address'    => [
                'name' => 'address',
                'type' => Type::listOf(Type::string())
            ],
            'phone'      => [
                'name' => 'phone',
                'type' => Type::listOf(Type::string())
            ],
            'notify'     => [
                'name' => 'notify',
                'type' => Type::nonNull(Type::boolean())
            ],
            'role_id'    => [
                'name' => 'role_id',
                'type' => Type::listOf(Type::id())
            ],
            'city_id'    => [
                'name' => 'city_id',
                'type' => Type::id()
            ],
        ];
    }

    public function resolve($root, $args): User
    {
        $user = new User();
        $user->fill($args);
        $user->save();

        if (isset($args['role_id'])) {
            $roles = Role::findOrFail($args['role_id']);
            $user->attachRoles($roles);
        }

        return $user;
    }
}
