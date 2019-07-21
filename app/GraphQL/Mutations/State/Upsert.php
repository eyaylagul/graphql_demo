<?php
namespace App\GraphQL\Mutations\State;

use App\Models\State;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use App\Traits\GraphQLAuth;

class Upsert extends Mutation
{
    use GraphQLAuth;

    protected $permissionReqAll = true;
    // todo not the best solution because in admin panel we have 2 separated method but here only one
    protected $permission = 'state.create|state.update';

    public function type()
    {
        return GraphQL::type('States');
    }

    public function rules(array $args = []) :array
    {
        $id = isset($args['id']) ? ',' . $args['id'] : null;

        return [
            'id'         => 'exists:state,id',
            'name'       => 'required|string|max:30|unique:state,name' . $id,
            'country_id' => 'required|exists:country,id'
        ];
    }

    public function args() :array
    {
        return [
            'id'         => [
                'name'        => 'id',
                'type'        => Type::id(),
                'description' => 'if exists then update'
            ],
            'name'       => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'country_id' => [
                'name' => 'country_id',
                'type' => Type::nonNull(Type::id())
            ],
        ];
    }

    public function resolve($root, $args): State
    {
        $state = State::updateOrCreate([
            'id' => array_get($args, 'id', null)
        ], [
            'name'       => $args['name'],
            'country_id' => $args['country_id'],
        ]);

        return $state;
    }
}
