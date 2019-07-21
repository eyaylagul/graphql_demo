<?php
namespace App\GraphQL\Queries;

use App\Models\Permission;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\GraphQL\Filters\PermissionFilter;
use Rebing\GraphQL\Support\Query;
use App\Traits\GraphQLAuth;
use Illuminate\Support\Arr;

class PermissionsQuery extends Query
{
    use GraphQLAuth;

    protected $permission = 'permission.view';

    protected $attributes = [
        'name' => 'Permissions Query',
        'description' => 'A query of permissions'
    ];

    public function type()
    {
        return GraphQL::paginate('Permissions');
    }

    public function args() :array
    {
        return [
            'filter' => ['name' => 'filter', 'type' => GraphQL::type('PermissionFilter')],
            'pagination' => ['name' => 'pagination', 'type' => GraphQL::type('Pagination')],
            'sort' => ['name' => 'sort', 'type' => GraphQL::type('Sortable')]
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return Permission::with($fields->getRelations())
            ->apiFilter(new PermissionFilter($args))
            ->apiSortable($args)
//            ->select($fields->getSelect())
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
