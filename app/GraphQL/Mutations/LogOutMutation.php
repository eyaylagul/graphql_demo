<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

// todo current method not working due to bug in JWT package
class LogOutMutation extends Mutation
{
    protected $attributes = [
        'name' => 'logOut'
    ];

    public function type()
    {
        return Type::nonNull(Type::string());
    }

    public function resolve() :string
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken()->get());

            return 'User logged out successfully';
        } catch (JWTException $exception) {
            return 'Sorry, the user cannot be logged out';
        }
    }
}
