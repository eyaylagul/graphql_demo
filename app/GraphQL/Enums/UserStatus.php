<?php
declare(strict_types=1);

namespace App\GraphQL\Enums;

use App\Enums\UserStatus as Status;
use Rebing\GraphQL\Support\EnumType;

class UserStatus extends EnumType
{
    public function __construct()
    {
        $this->attributes = [
            'name' => 'user_status',
            'values' => Status::toArray()
        ];
    }
}
