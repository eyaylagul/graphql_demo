<?php

namespace App\GraphQL\Types\Filters;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class RoleFilter extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'RoleFilter'
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
            'display_name'  => [
                'name' => 'display_name',
                'type' => Type::string()
            ],
            'created_at' => [
                'type' => GraphQL::type('DateTime'),
            ],
            'updated_at' => [
                'type' => GraphQL::type('DateTime'),
            ],
        ];
    }
}
