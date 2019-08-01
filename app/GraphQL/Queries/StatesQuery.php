<?php

namespace App\GraphQL\Queries;

use Closure;
use App\Models\State;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Filters\StateFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StatesQuery extends Query
{
    protected $attributes = [
        'name'        => 'States Query',
        'description' => 'A query of states'
    ];

    public function type(): GraphqlType
    {
        return GraphQL::paginate('States');
    }

    public function args(): array
    {
        return [
            'filter'     => ['name' => 'filter', 'type' => GraphQL::type('StateFilter')],
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

        return State::select($fields->getSelect())->with($fields->getRelations())
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
