<?php

namespace App\GraphQL\Types\Filters;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * Class UserType
 * @package App\GraphQL\Type
 *
 */
class UserFilter extends GraphQLType
{
    // This will output an InputObjectType instead of an OBjectType
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'UserFilter'
    ];

    public function fields() :array
    {
        return [
            'id'    => [
                'name' => 'id',
                'type' => Type::listOf(Type::int())
            ],
            'status'    => [
                'name' => 'status',
                'type' => GraphQL::type('UserStatus')
            ],
            'first_name'  => [
                'name' => 'first_name',
                'type' => Type::string()
            ],
            'last_name'  => [
                'name' => 'last_name',
                'type' => Type::string()
            ],
            'notify'  => [
                'name' => 'notify',
                'type' => Type::boolean()
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string()
            ],
            'city_id' => [
                'name' => 'city_id',
                'type' => Type::listOf(Type::id())
            ],
            'role_id' => [
                'name' => 'role_id',
                'type' => Type::listOf(Type::id())
            ],
            'created_at' => [
                'type' => GraphQL::type('DateTimeRange'),
                'description' => 'Date creating user'
            ],
            'updated_at' => [
                'type' => GraphQL::type('DateTimeRange'),
                'description' => 'Date updating user'
            ],
        ];
    }
}
