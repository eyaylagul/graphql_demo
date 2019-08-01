<?php
namespace App\GraphQL\Mutations\State;

use App\Models\State;
use App\Traits\GraphQLAuth;
use Illuminate\Support\Arr;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;

class Upsert extends Mutation
{
    use GraphQLAuth;

    protected $permissionReqAll = true;
    protected $permission = 'state.create|state.update';

    public function type(): GraphqlType
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
            'id' => Arr::get($args, 'id')
        ], [
            'name'       => $args['name'],
            'country_id' => $args['country_id'],
        ]);

        return $state;
    }
}
