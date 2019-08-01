<?php
namespace App\GraphQL\Mutations\Role;

use App\Models\Role;
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
    protected $permission = 'role.create|role.update';

    public function type(): GraphqlType
    {
        return GraphQL::type('Roles');
    }

    public function rules(array $args = []) :array
    {
        $id = isset($args['id']) ? ',' . $args['id'] : null;

        return [
            'id'            => 'exists:role,id',
            'name'          => 'required|unique:role,name' . $id,
            'display_name'  => 'required|string|max:255',
            'description'   => 'required',
            'permission_id' => 'exists:permission,id'
        ];
    }

    public function args() :array
    {
        return [
            'id'           => [
                'name' => 'id',
                'type' => Type::id(),
                'description' => 'if exists then update'
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'display_name' => [
                'name' => 'display_name',
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::nonNull(Type::string()),
            ],
            'permission_id' => [
                'name' => 'permission_id',
                'type' => Type::listOf(Type::id())
            ],
        ];
    }

    public function resolve($root, $args) :Role
    {
        $role = Role::updateOrCreate([
            'id' => Arr::get($args, 'id')
        ], [
            'name'         => $args['name'],
            'display_name' => $args['display_name'],
            'description'  => $args['description']
        ]);

        if (isset($args['permission_id'])) {
            $role->syncPermissions($args['permission_id']);
        }

        return $role;
    }
}
