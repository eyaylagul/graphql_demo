<?php

namespace App\GraphQL\Queries;

use Closure;
use App\Models\User;
use App\Traits\GraphQLAuth;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Filters\UserFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UsersQuery extends Query
{
    use GraphQLAuth;

    protected $permission = 'user.view';

    protected $attributes = [
        'name'        => 'Users Query',
        'description' => 'A query of users'
    ];

    public function type(): GraphqlType
    {
        return GraphQL::paginate('Users');
    }

    public function args(): array
    {
        return [
            'filter'     => ['name' => 'filter', 'type' => GraphQL::type('UserFilter')],
            'pagination' => ['name' => 'pagination', 'type' => GraphQL::type('Pagination')],
            'sort'       => ['name' => 'sort', 'type' => GraphQL::type('Sortable')]
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
    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields): LengthAwarePaginator
    {
        $fields = $getSelectFields();

        return User::select($fields->getSelect())->with($fields->getRelations())
            ->apiFilter(new UserFilter($args))
            ->apiSortable($args)
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
