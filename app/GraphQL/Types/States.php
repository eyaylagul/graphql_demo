<?php
namespace App\GraphQL\Types;

use App\Models\State;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class States extends GraphQLType
{
    protected $attributes = [
        'name' => 'States',
        'model' => State::class,
    ];

    public function fields() :array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'code' => [
                'type' => Type::string(),
            ],
            'country' => [
                'type' => Type::nonNull(GraphQL::type('Countries')),
            ]
        ];
    }
}
