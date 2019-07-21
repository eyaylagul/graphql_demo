<?php

namespace App\GraphQL\Types\Filters;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CityFilter extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'CityFilter'
    ];

    public function fields(): array
    {
        return [
            'id'       => [
                'name' => 'id',
                'type' => Type::listOf(Type::int())
            ],
            'name'     => [
                'name' => 'name',
                'type' => Type::string()
            ],
            'state_id' => [
                'name' => 'state_id',
                'type' => Type::id()
            ],
        ];
    }
}
