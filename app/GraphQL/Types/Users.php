<?php
namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\GraphQL\Filters\RoleFilter;

class Users extends GraphQLType
{
    protected $attributes = [
        'name' => 'Users',
        'model' => User::class,
    ];

    public function fields() :array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'first_name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'last_name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'phone' => [
                'type' => Type::listOf(Type::string()),
            ],
            'address' => [
                'type' => Type::listOf(Type::string()),
            ],
            'notify' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
            'status' => [
                'type' => Type::nonNull(GraphQL::type('UserStatus')),
            ],
            'created_at' => [
                'type' => Type::nonNull(GraphQL::type('DateTime')),
            ],
            'updated_at' => [
                'type' => Type::nonNull(GraphQL::type('DateTime')),
            ],
            'email_verified_at' => [
                'type' => GraphQL::type('DateTime'),
                'description' => 'Date verified email'
            ],
            'city' => [
                'type' => GraphQL::type('Cities'),
            ],
            'roles' => [
                'type' => Type::listOf(GraphQL::type('Roles')),
                'args' => [
                    'filter' => ['name' => 'filter', 'type' => GraphQL::type('RoleFilter')],
                    'sort' => ['name' => 'sort', 'type' => GraphQL::type('Sortable')]
                ],
            ]
        ];
    }

    public function resolveRolesField($root, $args)
    {
        return $root->roles()->apiFilter(new RoleFilter($args))->apiSortable($args)->get();
    }
}
