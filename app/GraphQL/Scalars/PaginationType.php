<?php

namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Pagination\LengthAwarePaginator;
use Rebing\GraphQL\Support\Facades\GraphQL;

class PaginationType extends ObjectType
{
    public function __construct($typeName, $customName = null)
    {
        $name = $customName ?: $typeName . 'Pagination';

        $config = [
            'name'  => $name,
            'fields' => array_merge(
                $this->getPaginationFields(),
                [
                    'data' => [
                        'type'      => GraphQLType::listOf(GraphQL::type($typeName)),
                        'resolve'   => static function (LengthAwarePaginator $data) {
                            return $data->getCollection();
                        },
                    ],
                ]
            )
        ];

        parent::__construct($config);
    }

    protected function getPaginationFields() :array
    {
        return [
            'total' => [
                'type'          => GraphQLType::nonNull(GraphQLType::int()),
                'description'   => 'Number of total items selected by the query',
                'resolve'       => static function (LengthAwarePaginator $data) {
                    return $data->total();
                },
                'selectable'    => false,
            ],
            'per_page' => [
                'type'          => GraphQLType::nonNull(GraphQLType::int()),
                'description'   => 'Number of items returned per page',
                'resolve'       => static function (LengthAwarePaginator $data) {
                    return $data->perPage();
                },
                'selectable'    => false,
            ],
            'current_page' => [
                'type'          => GraphQLType::nonNull(GraphQLType::int()),
                'description'   => 'Current page of the cursor',
                'resolve'       => static function (LengthAwarePaginator $data) {
                    return $data->currentPage();
                },
                'selectable'    => false,
            ],
            'from' => [
                'type'          => GraphQLType::int(),
                'description'   => 'Number of the first item returned',
                'resolve'       => static function (LengthAwarePaginator $data) {
                    return $data->firstItem();
                },
                'selectable'    => false,
            ],
            'to' => [
                'type'          => GraphQLType::int(),
                'description'   => 'Number of the last item returned',
                'resolve'       => function (LengthAwarePaginator $data) {
                    return $data->lastItem();
                },
                'selectable'    => false,
            ],
            'hasMorePages' => [
                'type'          => GraphQLType::boolean(),
                'description'   => 'Does it have next page',
                'resolve'       => function (LengthAwarePaginator $data) {
                    return $data->hasMorePages();
                },
                'selectable'    => false,
            ],
            'hasPages' => [
                'type'          => GraphQLType::boolean(),
                'description'   => 'Does it have any page',
                'resolve'       => static function (LengthAwarePaginator $data) {
                    return $data->hasPages();
                },
                'selectable'    => false,
            ],
            'lastPage' => [
                'type'          => GraphQLType::int(),
                'description'   => 'Number of the last page returned',
                'resolve'       => static function (LengthAwarePaginator $data) {
                    return $data->lastPage();
                },
                'selectable'    => false,
            ],
        ];
    }
}
