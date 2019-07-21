<?php
namespace App\GraphQL\Types;

use App\Models\City;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class Cities extends GraphQLType
{
    protected $attributes = [
        'name' => 'Cities',
        'model' => City::class,
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
            'lat' => [
                'type' => Type::nonNull(Type::float()),
            ],
            'lng' => [
                'type' => Type::nonNull(Type::float()),
            ],
            'state' => [
                'type' => Type::nonNull(GraphQL::type('States')),
            ],
        ];
    }
}
