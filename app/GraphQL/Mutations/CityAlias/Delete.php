<?php

namespace App\GraphQL\Mutations\CityAlias;

use App\Models\CityAlias;
use App\Traits\GraphQLAuth;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type as GraphqlType;

class Delete extends Mutation
{
    use GraphQLAuth;

    protected $permission = 'city_alias.delete';

    public function type(): GraphqlType
    {
        return Type::listOf(Type::id());
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::listOf(Type::id())),
            ],
        ];
    }

    public function resolve($root, $args): array
    {
        $city = CityAlias::find($args['id']);
        $ids   = $city->pluck('id')->toArray();
        CityAlias::destroy($args['id']);

        return $ids;
    }
}
