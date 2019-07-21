<?php

namespace App\GraphQL\Enum;

use Rebing\GraphQL\Support\Type as GraphQLType;

class UserStatus extends GraphQLType
{
    protected $enumObject = true;

    protected $attributes = [
        'name' => 'user_status',
        'values' => [
            'available', 'blocked'
        ],
    ];
}
