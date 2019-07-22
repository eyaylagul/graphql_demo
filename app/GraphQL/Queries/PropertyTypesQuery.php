<?php

namespace App\GraphQL\Queries;

use App\Models\PropertyType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use App\GraphQL\Filters\PropertyTypeFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Arr;

class PropertyTypesQuery extends Query
{
    protected $attributes = [
        'name'        => 'PropertyTypes Query',
        'description' => 'A query of property types'
    ];

    public function type()
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
     * @param              $root
     * @param              $args
     * @param SelectFields $fields
     * @param ResolveInfo  $info
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return PropertyType::with(array_keys($fields->getRelations()))
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
