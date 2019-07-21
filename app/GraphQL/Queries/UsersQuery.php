<?php
namespace App\GraphQL\Queries;

use App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use App\GraphQL\Filters\UserFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Query;
use App\Traits\GraphQLAuth;
use Illuminate\Support\Arr;

class UsersQuery extends Query
{
    use GraphQLAuth;

    protected $permission = 'user.view';

    protected $attributes = [
        'name' => 'Users Query',
        'description' => 'A query of users'
    ];

    public function type()
    {
        return GraphQL::paginate('Users');
    }

    public function args() :array
    {
        return [
            'filter' => ['name' => 'filter', 'type' => GraphQL::type('UserFilter')],
            'pagination' => ['name' => 'pagination', 'type' => GraphQL::type('Pagination')],
            'sort' => ['name' => 'sort', 'type' => GraphQL::type('Sortable')]
        ];
    }

    /**
     * @param              $root
     * @param              $args
     * @param SelectFields $fields
     * @param ResolveInfo  $info
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return User::with(array_keys($fields->getRelations()))
                ->apiFilter(new UserFilter($args))
                ->apiSortable($args)
//                ->select($fields->getSelect())
                ->paginate(
                    Arr::get($args, 'pagination.take'),
                    ['*'],
                    'page',
                    Arr::get($args, 'pagination.page')
                );
    }
}
