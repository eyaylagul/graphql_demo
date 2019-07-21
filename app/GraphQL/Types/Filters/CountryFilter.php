<?php

namespace App\GraphQL\Types\Filters;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CountryFilter extends GraphQLType
{
    // This will output an InputObjectType instead of an OBjectType
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'CountryFilter'
    ];

    public function fields() :array
    {
        return [
            'id'    => [
                'name' => 'id',
                'type' => Type::listOf(Type::int())
            ],
            'name'  => [
                'name' => 'name',
                'type' => Type::string()
            ],
            'code' => [
                'name' => 'code',
                'type' => Type::string()
            ],
        ];
    }
}
