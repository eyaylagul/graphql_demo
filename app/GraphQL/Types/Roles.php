<?php
namespace App\GraphQL\Types;

use App\Models\Role;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\GraphQL\Filters\PermissionFilter;
use App\GraphQL\Filters\UserFilter;

class Roles extends GraphQLType
{
    protected $attributes = [
        'name' => 'Roles',
        'model' => Role::class,
    ];

    public function fields() :array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'System name is using by system'
            ],
            'display_name' => [
                'type' => Type::nonNull(Type::string())
            ],
            'description' => [
                'type' => Type::nonNull(Type::string())
            ],
            'created_at' => [
                'type' => Type::nonNull(GraphQL::type('DateTime'))
            ],
            'updated_at' => [
                'type' => Type::nonNull(GraphQL::type('DateTime'))
            ],
            'permissions' => [
                'type' => Type::listOf(GraphQL::type('Permissions')),
                'description' => 'The permission of the role',
                'args' => [
                    'filter' => ['name' => 'filter', 'type' => GraphQL::type('PermissionFilter')],
                    'sort' => ['name' => 'sort', 'type' => GraphQL::type('Sortable')]
                ],
            ],
            'users' => [
                'type' => Type::listOf(GraphQL::type('Users')),
                'description' => 'The type of the user',
                'args' => [
                    'filter' => ['name' => 'filter', 'type' => GraphQL::type('UserFilter')],
                    'sort' => ['name' => 'sort', 'type' => GraphQL::type('Sortable')]
                ],
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

    public function resolveUsersField($query, $args)
    {
        return $query->users()->apiFilter(new UserFilter($args))->apiSortable($args)->get();
    }
}
