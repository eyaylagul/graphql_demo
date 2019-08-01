<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Models\Role;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphqlType;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

// todo need to check method and Think how to make it
// user should verify email? or login after
class SignUpMutation extends Mutation
{
    protected $attributes = [
        'name' => 'signUp'
    ];

    public function type(): GraphqlType
    {
        return Type::string();

//        return [
//            'user' => GraphQL::type('Users'),
//            'auth' => GraphQL::type('Auth')
//        ];
    }

    public function rules(array $args = []) :array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:user,email',
            'password' => 'required|string|min:8',
        ];
    }

    public function args() :array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }

    public function resolve($root, $args) :array
    {
//        $user = new User();
//        $user->fill($args);
//        $user->save();
//
//        if (isset($args['role_id'])) {
//            $roles = Role::findOrFail($args['role_id']);
//            $user->attachRoles($roles);
//        }
//
////        return $user;
//
//        return auth()->login($user);
//        return [
//            'user' => $user,
//            'auth' => [
//                'access_token' => $token,
//                'token_type'   => 'bearer',
//                'expires_in'   => JWTAuth::factory()->getTTL() * 60
//            ]
//        ];
        // generate token for user and return the token
//        return auth()->login($user);
    }
}
