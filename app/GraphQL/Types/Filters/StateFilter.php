<?php

namespace App\GraphQL\Types\Filters;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class StateFilter extends GraphQLType
{
    // This will output an InputObjectType instead of an OBjectType
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'StateFilter'
    ];

    public function fields() :array
    {
        return [
            'id'    => [
                'name' => 'id',
                'type' => Type::listOf(Type::int())
            ],
            'code'  => [
                'name' => 'code',
                'type' => Type::string()
            ],
            'name'  => [
                'name' => 'name',
                'type' => Type::string()
            ],
            'country_id' => [
                'name' => 'country_id',
                'type' => Type::id()
            ],
        ];
    }
}
