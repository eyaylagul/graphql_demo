<?php

namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Pagination extends GraphQLType
{
    // This will output an InputObjectType instead of an OBjectType
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'Pagination'
    ];

    public function fields(): array
    {
        return [
            'take' => [
                'name'        => 'take',
                'description' => 'How many items do you need?',
                'type'        => Type::int()
            ],
            'page' => [
                'name'        => 'page',
                'description' => 'which page do you need?',
                'type'        => Type::int()
            ],
        ];
    }
}
