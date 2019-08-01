<?php

namespace App\GraphQL\Mutations\City;

use App\Models\City;
use App\Traits\GraphQLAuth;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type as GraphqlType;

class Delete extends Mutation
{
    use GraphQLAuth;

    protected $permission = 'city.delete';

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
        $city = City::find($args['id']);
        $ids   = $city->pluck('id')->toArray();
        City::destroy($args['id']);

        return $ids;
    }
}
