<?php
namespace App\GraphQL\Types;

use App\GraphQL\Filters\PropertyMediaFilter;
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
            /* todo replace with strict json type  because it has only 3 field */
            'initiator' => [
                'type' => GraphQL::type('Json')
            ],
            'features' => [
                'type' => GraphQL::type('Json')
            ],
            'type' => [
                'type' => Type::nonNull(GraphQL::type('PropertyTypes')),
            ],
            'city' => [
                'type' => Type::nonNull(GraphQL::type('Cities')),
            ],
            'media' => [
                'type' => Type::listOf(GraphQL::type('PropertyMedia')),
                'args' => [
                    'filter' => ['name' => 'filter', 'type' => GraphQL::type('PropertyMediaFilter')],
                    'sort' => ['name' => 'sort', 'type' => GraphQL::type('Sortable')]
                ],
                /* todo doesn't work */
//                'query' => static function (array $args, $query) {
//                    dd($args);
////                    if (isset($args['filter']['is_primary'])) {
////                        return $query->media->find($args['filter']['is_primary']);
////                    }
//                    return $query->media()->apiSortable($args)->get();
////                    dd($query);
////                    return $query->media()->apiFilter(new PropertyMediaFilter($args))->apiSortable($args);
//                },
            ],
        ];
    }

//    public function resolveMediaField($query, $args)
//    {
//        return $query->media()->apiSortable($args)->get();
//        // working fine but to use all filter, too much if and dublications
////        if (isset($args['filter']['id'])) {
////            return $query->permissions->find($args['filter']['id']);
////        }
//        // permissions is collection so I cant use scope function from traits
////        return $query->permissions->apiFilter(new PermissionFilter($args))->apiSortable($args)->get(); // Preferable variant
////        return $query->media()->apiFilter(new PropertyMediaFilter($args))->apiSortable($args)->get();
//    }
}
