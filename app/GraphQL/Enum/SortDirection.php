<?php

namespace App\GraphQL\Enum;

use Rebing\GraphQL\Support\Type as GraphQLType;

class SortDirection extends GraphQLType
{
    protected $enumObject = true;

    protected $attributes = [
        'name' => 'SortDirection',
        'values' => [
            'asc' => 'asc',
            'desc' => 'desc',
        ],
    ];
}
