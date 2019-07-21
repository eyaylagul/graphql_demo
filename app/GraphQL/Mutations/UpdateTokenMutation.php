<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Rebing\GraphQL\Support\Facades\GraphQL;

// todo current method not working due to bug in JWT package
class UpdateTokenMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateToken'
    ];

    public function type()
    {
        return GraphQL::type('Auth');
    }

    public function resolve() :array
    {
        try {
            // check that token is valid
            if ($token = JWTAuth::getToken()) {
                JWTAuth::checkOrFail();
            }
            // generate new one
            $user = JWTAuth::authenticate();
            JWTAuth::setToken($token);
            JWTAuth::unsetToken();
            $newToken = JWTAuth::fromUser($user);
        } catch (TokenExpiredException $e) {
            throw new \Exception('Token was not found!');
        }
        return [
            'access_token' => $newToken,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            'user'         => $user
        ];
    }
}
