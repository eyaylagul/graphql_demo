<?php
namespace App\GraphQL\Types;

use App\Models\Property;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class Properties extends GraphQLType
{
    protected $attributes = [
        'name' => 'Properties',
        'model' => Property::class,
    ];

    public function fields() :array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
            ],
            'status' => [
                'type' => Type::nonNull(GraphQL::type('PropertyStatus')),
            ],
            'expire_at' => [
                'type' => GraphQL::type('Date'),
            ],
            'available_at' => [
                'type' => GraphQL::type('Date'),
            ],
            'created_at' => [
                'type' => Type::nonNull(GraphQL::type('DateTime')),
            ],
            'updated_at' => [
                'type' => Type::nonNull(GraphQL::type('DateTime')),
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'price' => [
                'type' => Type::int(),
            ],
            'price_max' => [
                'type' => Type::int(),
            ],
            'address' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'postcode' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'square_feet' => [
                'type' => Type::int(),
            ],
            'pets' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
            'bedrooms' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'bathrooms' => [
                'type' => Type::nonNull(Type::float()),
            ],
            'lat' => [
                'type' => Type::nonNull(Type::float()),
            ],
            'lng' => [
                'type' => Type::nonNull(Type::float()),
            ],
            'initiator' => [
                'type' => Type::string(),
//                'type'          => Type::listOf(GraphQL::type('post')),
                'description'   => 'A list of posts written by the user',
                // Now this will simply request the "posts" column, and it won't
                // query for all the underlying columns in the "post" object
                // The value defaults to true
//                'is_relation' => false
            ],
            'type' => [
                'type' => Type::nonNull(GraphQL::type('PropertyTypes')),
            ],
            'city' => [
                'type' => Type::nonNull(GraphQL::type('Cities')),
            ],
        ];
    }
}
