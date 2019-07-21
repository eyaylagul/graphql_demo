<?php

namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class IntRange extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'IntRange'
    ];

    public function fields() :array
    {
        return [
            'gt'  => [
                'name' => 'gt',
                'description' => 'Greater than',
                'type' => Type::int()
            ],
            'gte'  => [
                'name' => 'gte',
                'description' => 'Greater than or equal',
                'type' => Type::int()
            ],
            'lt'  => [
                'name' => 'lt',
                'description' => 'Less than',
                'type' => Type::int()
            ],
            'lte'  => [
                'name' => 'lte',
                'description' => 'Less than or equal',
                'type' => Type::int()
            ],
            'empty'  => [
                'name' => 'empty',
                'description' => 'empty/nullable',
                'type' => Type::boolean()
            ],
        ];
    }
}
