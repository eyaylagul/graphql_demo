<?php
namespace App\GraphQL\Queries;

use Closure;
use App\Models\Role;
use App\Traits\GraphQLAuth;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Filters\RoleFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RolesQuery extends Query
{
    use GraphQLAuth;

    protected $permission = 'role.view';

    protected $attributes = [
        'name' => 'Roles Query',
        'description' => 'A query of roles'
    ];

    public function type(): GraphqlType
    {
        return GraphQL::paginate('Roles');
    }

    public function args() :array
    {
        return [
            'filter' => ['name' => 'filter', 'type' => GraphQL::type('RoleFilter')],
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

        return Role::select($fields->getSelect())->with($fields->getRelations())
            ->apiFilter(new RoleFilter($args))
            ->apiSortable($args)
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
