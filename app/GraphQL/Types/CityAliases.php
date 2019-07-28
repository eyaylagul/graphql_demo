<?php
namespace App\GraphQL\Types;

use App\Models\CityAlias;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CityAliases extends GraphQLType
{
    protected $attributes = [
        'name' => 'CityAliases',
        'model' => CityAlias::class,
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
            'city' => [
                'type' => Type::nonNull(GraphQL::type('Cities')),
            ],
        ];
    }
}
