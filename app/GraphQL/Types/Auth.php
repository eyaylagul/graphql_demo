<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class Auth extends GraphQLType
{
    protected $attributes = [
        'name' => 'Auth'
    ];

    public function fields(): array
    {
        return [
            'access_token' => [
                'name' => 'access_token',
                'type' => Type::nonNull(Type::string()),
            ],
            'token_type'   => [
                'name' => 'token_type',
                'type' => Type::nonNull(Type::string()),
            ],
            'expires_in'   => [
                'name'        => 'expires_in',
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Value in seconds'
            ],
            'user'         => [
                'type'        => Type::nonNull(GraphQL::type('Users')),
                'description' => 'The type of the user'
            ]
        ];
    }
}
