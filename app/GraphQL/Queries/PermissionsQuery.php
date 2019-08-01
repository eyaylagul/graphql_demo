<?php
namespace App\GraphQL\Queries;

use Closure;
use App\Models\Permission;
use App\Traits\GraphQLAuth;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use App\GraphQL\Filters\PermissionFilter;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PermissionsQuery extends Query
{
    use GraphQLAuth;

    protected $permission = 'permission.view';

    protected $attributes = [
        'name' => 'Permissions Query',
        'description' => 'A query of permissions'
    ];

    public function type() :GraphqlType
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

    /**
     * @param             $root
     * @param             $args
     * @param             $context
     * @param ResolveInfo $info
     * @param Closure     $getSelectFields
     *
     * @return LengthAwarePaginator
     */
    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields) :LengthAwarePaginator
    {
        $fields = $getSelectFields();

        return Permission::select($fields->getSelect())->with($fields->getRelations())
            ->apiFilter(new PermissionFilter($args))
            ->apiSortable($args)
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
