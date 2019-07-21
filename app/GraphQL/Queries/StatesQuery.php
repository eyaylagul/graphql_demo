<?php

namespace App\GraphQL\Queries;

use App\Models\State;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use App\GraphQL\Filters\StateFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Arr;

class StatesQuery extends Query
{
    protected $attributes = [
        'name'        => 'States Query',
        'description' => 'A query of states'
    ];

    public function type()
    {
        return GraphQL::paginate('States');
    }

    public function args(): array
    {
        return [
            'filter' => ['name' => 'filter', 'type' => GraphQL::type('StateFilter')],
            'pagination' => ['name' => 'pagination', 'type' => GraphQL::type('Pagination')],
            'sort'   => ['name' => 'sort', 'type' => GraphQL::type('Sortable')]
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
        return State::with(array_keys($fields->getRelations()))
            ->apiFilter(new StateFilter($args))
            ->apiSortable($args)
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
