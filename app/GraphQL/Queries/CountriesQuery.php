<?php

namespace App\GraphQL\Queries;

use App\Models\Country;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;
use App\GraphQL\Filters\CountryFilters;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Arr;

class CountriesQuery extends Query
{
    protected $attributes = [
        'name'        => 'Countries Query',
        'description' => 'A query of Countries'
    ];

    public function type()
    {
        return GraphQL::paginate('Countries');
    }

    public function args(): array
    {
        return [
            'filter'     => ['name' => 'filter', 'type' => GraphQL::type('CountryFilter')],
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
        return Country::with(array_keys($fields->getRelations()))
            ->apiFilter(new CountryFilters($args))
            ->apiSortable($args)
            ->paginate(
                Arr::get($args, 'pagination.take'),
                ['*'],
                'page',
                Arr::get($args, 'pagination.page')
            );
    }
}
