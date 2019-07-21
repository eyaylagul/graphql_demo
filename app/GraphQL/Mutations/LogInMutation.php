<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use JWTAuth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\User;

class LogInMutation extends Mutation
{
    protected $attributes = [
        'name' => 'logIn'
    ];

    public function type()
    {
        return GraphQL::type('Auth');
    }

    public function rules(array $args = []) :array
    {
        return [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function args() :array
    {
        return [
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
        $credentials = [
            'email'    => $args['email'],
            'password' => $args['password']
        ];

        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            throw new \Exception('invalid credentials!');
        }

        $user = User::where('email', $args['email'])->first();
        if ($user['status'] !== 'available') {
            throw new \Exception('user has been blocked!');
        }

        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            'user'         => $user
        ];
    }
}
