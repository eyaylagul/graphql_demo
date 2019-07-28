<?php

namespace App\GraphQL\Mutations\CityAlias;

use App\Models\CityAlias;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use App\Traits\GraphQLAuth;
use Illuminate\Support\Arr;

class Upsert extends Mutation
{
    use GraphQLAuth;

    protected $permissionReqAll = true;
    protected $permission = 'city_alias.create|city_alias.update';

    public function type()
    {
        return GraphQL::type('CityAliases');
    }

    public function rules(array $args = []): array
    {
        return [
            'id'      => 'exists:city_alias,id',
            'name'    => 'required|string|max:100',
            'city_id' => 'required|exists:city,id'
        ];
    }

    public function args(): array
    {
        return [
            'id'      => [
                'name' => 'id',
                'type' => Type::id(),
            ],
            'name'    => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'city_id' => [
                'name' => 'city_id',
                'type' => Type::nonNull(Type::id())
            ],
        ];
    }

    public function resolve($root, $args): CityAlias
    {
        $alias = CityAlias::updateOrCreate([
            'id' => Arr::get($args, 'id')
        ], [
            'name'    => $args['name'],
            'city_id' => $args['city_id']
        ]);

        return $alias;
    }
}
