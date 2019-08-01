<?php

namespace App\GraphQL\Queries;

use Closure;
use App\Models\CityAlias;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Filters\BaseFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CityAliasesQuery extends Query
{
    protected $attributes = [
        'name'        => 'City Aliases Query',
        'description' => 'A query of city aliases'
    ];

    public function type(): GraphqlType
    {
        return GraphQL::paginate('CityAliases');
    }

    public function args(): array
    {
        return [
            'filter'     => ['name' => 'filter', 'type' => GraphQL::type('CityAliasFilter')],
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

        return CityAlias::select($fields->getSelect())->with($fields->getRelations())
            ->apiFilter(new BaseFilter($args))
            ->apiSortable($args)
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
