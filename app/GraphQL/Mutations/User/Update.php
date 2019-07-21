<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use App\Models\Role;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use App\Traits\GraphQLAuth;

class Update extends Mutation
{
    use GraphQLAuth;

    protected $permission = 'user.update';

    public function type()
    {
        return GraphQL::type('Users');
    }

    public function rules(array $args = []): array
    {
        return [
            'id'         => 'required|exists:user,id',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|max:255|email|unique:user,email,' . $args['id'],
            'role_id'    => 'required|exists:role,id',
            'city_id'    => 'nullable|exists:city,id',
            'phone.*'    => 'nullable|numeric'
        ];
    }

    public function args(): array
    {
        return [
            'id'         => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
            ],
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
            'status'     => [
                'name' => 'status',
                'type' => Type::nonNull(GraphQL::type('UserStatus'))
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
        $user = User::find($args['id']);

        $user->fill($args);
        $user->save();

        if (isset($args['role_id'])) {
            $roles = Role::findOrFail($args['role_id']);
            $user->syncRoles($roles);
        }

        return $user;
    }
}
