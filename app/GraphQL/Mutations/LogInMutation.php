<?php

namespace App\GraphQL\Mutations;

use JWTAuth;
use App\Models\User;
use Rebing\GraphQL\Error\AuthorizationError;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;

class LogInMutation extends Mutation
{
    protected $attributes = [
        'name' => 'logIn'
    ];

    public function type(): GraphqlType
    {
        return GraphQL::type('Auth');
    }

    public function rules(array $args = []): array
    {
        return [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function args(): array
    {
        return [
            'email'    => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $credentials = [
            'email'    => $args['email'],
            'password' => $args['password']
        ];

        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            return new AuthorizationError('invalid credentials!');
        }

        $user = User::where('email', $args['email'])->first();
        if (!$user || $user['status'] !== 'AVAILABLE') {
            return new AuthorizationError('user has been blocked!');
        }

        // login into default auth
        $emails = explode(',', config('app.email_admin'));
        if (in_array($user->email, $emails, true)) {
            Auth::attempt($credentials, true);
        }

        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            'user'         => $user
        ];
    }
}
