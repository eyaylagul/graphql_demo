<?php

namespace App\GraphQL\Types\Filters;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PropertyTypeFilter extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'PropertyTypeFilter'
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
            'description' => [
                'name' => 'description',
                'type' => Type::id()
            ],
        ];
    }
}
