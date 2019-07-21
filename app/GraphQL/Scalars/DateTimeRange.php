<?php

namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class DateTimeRange extends GraphQLType
{
    // This will output an InputObjectType instead of an OBjectType
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'DateTimeRange'
    ];

    public function fields() :array
    {
        return [
            'gt'  => [
                'name' => 'gt',
                'description' => 'Greater than',
                'type' => GraphQL::type('DateTime')
            ],
            'gte'  => [
                'name' => 'gte',
                'description' => 'Greater than or equal',
                'type' => GraphQL::type('DateTime')
            ],
            'lt'  => [
                'name' => 'lt',
                'description' => 'Less than',
                'type' => GraphQL::type('DateTime')
            ],
            'lte'  => [
                'name' => 'lte',
                'description' => 'Less than or equal',
                'type' => GraphQL::type('DateTime')
            ],
            'empty'  => [
                'name' => 'empty',
                'description' => 'empty',
                'type' => Type::boolean()
            ],
        ];
    }
}
