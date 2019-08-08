<?php

namespace App\GraphQL\Queries;

use Closure;
use App\Models\Property;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Filters\CityFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PropertiesQuery extends Query
{
    protected $attributes = [
        'name'        => 'Properties Query',
        'description' => 'A query of properties'
    ];

    public function type(): GraphqlType
    {
        return GraphQL::paginate('Properties');
    }

    public function args(): array
    {
        return [
//            'filter'     => ['name' => 'filter', 'type' => GraphQL::type('CityFilter')],
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
//        $info->getFieldSelection($depth = 3);
        $fields = $getSelectFields();

        return Property::select($fields->getSelect())->with($fields->getRelations())
//            ->apiFilter(new CityFilter($args))
//            ->apiSortable($args)
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
