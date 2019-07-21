<?php

namespace App\GraphQL\Mutations\Role;

use App\Models\Role;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use App\Traits\GraphQLAuth;

class Delete extends Mutation
{
    use GraphQLAuth;

    protected $permission = 'role.delete';

    public function type()
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
        $role = Role::find($args['id']);
        $ids   = $role->pluck('id')->toArray();
        Role::destroy($args['id']);

        return $ids;
    }
}
