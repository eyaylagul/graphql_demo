<?php
namespace App\GraphQL\Mutations\User;

use App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use App\Traits\GraphQLAuth;

class UpdatePassword extends Mutation
{
//    use GraphQLAuth;
//
//    protected $permission = 'user.update.password';

    public function type()
    {
        return GraphQL::type('Users');
    }

    public function rules(array $args = []) :array
    {
        return [
            'id' => 'required|exists:user,id',
            'password' => 'required|string|min:8',
        ];
    }

    public function args() :array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id()),
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string())
            ],
        ];
    }

    public function resolve($root, $args) :User
    {
        $user = User::find($args['id']);

        $user->password = $args['password'];
        $user->save();
        return $user;
    }
}
