<?php

namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Sortable extends GraphQLType
{
    // This will output an InputObjectType instead of an OBjectType
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'Sortable'
    ];

    public function fields() :array
    {
        return [
            'sort_by'    => [
                'name' => 'sort_by',
                'description' => 'Write one of existing field current object',
                'type' => Type::string()
            ],
            'type'  => [
                'name' => 'type',
                'description' => 'Choose sorting type',
                'type' => GraphQL::type('SortDirection')
            ],
        ];
    }
}
