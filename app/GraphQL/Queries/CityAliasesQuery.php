<?php

namespace App\GraphQL\Queries;

use App\GraphQL\Filters\BaseFilter;
use App\Models\CityAlias;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Arr;

class CityAliasesQuery extends Query
{
    protected $attributes = [
        'name'        => 'City Aliases Query',
        'description' => 'A query of city aliases'
    ];

    public function type()
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
     * @param              $root
     * @param              $args
     * @param SelectFields $fields
     * @param ResolveInfo  $info
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return CityAlias::with(array_keys($fields->getRelations()))
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
