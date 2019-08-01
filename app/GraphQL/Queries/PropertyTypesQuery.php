<?php

namespace App\GraphQL\Queries;

use Closure;
use Illuminate\Support\Arr;
use App\Models\PropertyType;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\GraphQL\Filters\PropertyTypeFilter;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PropertyTypesQuery extends Query
{
    protected $attributes = [
        'name'        => 'PropertyTypes Query',
        'description' => 'A query of property types'
    ];

    public function type(): GraphqlType
    {
        return GraphQL::paginate('PropertyTypes');
    }

    public function args(): array
    {
        return [
            'filter'     => ['name' => 'filter', 'type' => GraphQL::type('PropertyTypeFilter')],
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

        return PropertyType::select($fields->getSelect())->with($fields->getRelations())
            ->apiFilter(new PropertyTypeFilter($args))
            ->apiSortable($args)
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
