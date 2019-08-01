<?php

namespace App\GraphQL\Mutations\State;

use App\Models\State;
use App\Traits\GraphQLAuth;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type as GraphqlType;

class Delete extends Mutation
{
    use GraphQLAuth;

    protected $permission = 'state.delete';

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
        $state = State::find($args['id']);
        $ids   = $state->pluck('id')->toArray();
        State::destroy($args['id']);

        return $ids;
    }
}
