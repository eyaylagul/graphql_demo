<?php

namespace App\GraphQL\Types\Filters;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class PropertyMediaFilter extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'PropertyMediaFilter'
    ];

    public function fields() :array
    {
        return [
            'is_primary'  => [
                'name' => 'is_primary',
                'type' => Type::boolean()
            ],
            'is_local'  => [
                'name' => 'is_local',
                'type' => Type::boolean()
            ],
            'type' => [
                'name' => 'type',
                'type' => GraphQL::type('PropertyMediaType'),
            ],
            'created_at' => [
                'type' => GraphQL::type('DateTimeRange'),
            ],
            'updated_at' => [
                'type' => GraphQL::type('DateTimeRange'),
            ],
        ];
    }
}
