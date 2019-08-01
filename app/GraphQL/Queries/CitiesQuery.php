<?php

namespace App\GraphQL\Queries;

use Closure;
use App\Models\City;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Filters\CityFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CitiesQuery extends Query
{
    protected $attributes = [
        'name'        => 'Cities Query',
        'description' => 'A query of cities'
    ];

    public function type() :GraphqlType
    {
        return GraphQL::paginate('Cities');
    }

    public function args(): array
    {
        return [
            'filter'     => ['name' => 'filter', 'type' => GraphQL::type('CityFilter')],
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
    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields) :LengthAwarePaginator
    {
        $fields = $getSelectFields();

        return City::select($fields->getSelect())->with($fields->getRelations())
            ->apiFilter(new CityFilter($args))
            ->apiSortable($args)
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
