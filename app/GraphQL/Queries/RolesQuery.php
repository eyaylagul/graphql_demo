<?php
namespace App\GraphQL\Queries;

use App\Models\Role;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\GraphQL\Filters\RoleFilter;
use Rebing\GraphQL\Support\Query;
use App\Traits\GraphQLAuth;
use Illuminate\Support\Arr;

class RolesQuery extends Query
{
    use GraphQLAuth;

    protected $permission = 'role.view';

    protected $attributes = [
        'name' => 'Roles Query',
        'description' => 'A query of roles'
    ];

    public function type()
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
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return Role::with($fields->getRelations())
            ->apiFilter(new RoleFilter($args))
            ->apiSortable($args)
            ->select($fields->getSelect())
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
