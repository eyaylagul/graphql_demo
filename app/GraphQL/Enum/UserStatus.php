<?php

namespace App\GraphQL\Enum;

use App\Enums\UserStatus as Status;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserStatus extends GraphQLType
{
    protected $enumObject = true;

    public function __construct($attributes = [])
    {
        $this->attributes = [
            'name' => 'user_status',
            'values' => Status::toArray()
        ];
        parent::__construct($attributes);
    }
}
