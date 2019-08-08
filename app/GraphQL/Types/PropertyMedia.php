<?php
namespace App\GraphQL\Types;

use App\GraphQL\Filters\PermissionFilter;
use App\Models\PropertyMedia as Media;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class PropertyMedia extends GraphQLType
{
    protected $attributes = [
        'name' => 'PropertyMedia',
        'model' => Media::class,
    ];

    public function fields() :array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
            ],
            'path' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'position' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'is_primary' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
            'is_local' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
            'type' => [
                'type' => Type::nonNull(GraphQL::type('PropertyMediaType')),
            ],
            'created_at' => [
                'type' => Type::nonNull(GraphQL::type('DateTime')),
            ],
            'updated_at' => [
                'type' => Type::nonNull(GraphQL::type('DateTime')),
            ]
        ];
    }

    // todo need find solution to prevent n+1 problem
    public function resolvePermissionsField($query, $args)
    {
        // working fine but to use all filter, too much if and dublications
//        if (isset($args['filter']['id'])) {
//            return $query->permissions->find($args['filter']['id']);
//        }
        // permissions is collection so I cant use scope function from traits
//        return $query->permissions->apiFilter(new PermissionFilter($args))->apiSortable($args)->get(); // Preferable variant
        return $query->permissions()->apiFilter(new PermissionFilter($args))->apiSortable($args)->get();
    }
}
