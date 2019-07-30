<?php

namespace App\GraphQL\Queries;

use App\Models\Property;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use App\GraphQL\Filters\CityFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Arr;

class PropertiesQuery extends Query
{
    protected $attributes = [
        'name'        => 'Properties Query',
        'description' => 'A query of properties'
    ];

    public function type()
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
     * @param              $root
     * @param              $args
     * @param SelectFields $fields
     * @param ResolveInfo  $info
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return Property::with(array_keys($fields->getRelations()))
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
