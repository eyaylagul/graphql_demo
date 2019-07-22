<?php
namespace App\GraphQL\Types;

use App\Models\PropertyType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PropertyTypes extends GraphQLType
{
    protected $attributes = [
        'name' => 'PropertyTypes',
        'model' => PropertyType::class,
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
            'description' => [
                'type' => Type::nonNull(Type::string()),
            ]
        ];
    }
}
