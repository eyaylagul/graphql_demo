<?php
declare(strict_types=1);

namespace App\GraphQL\Enums;

use App\Enums\PropertyStatus as Status;
use Rebing\GraphQL\Support\EnumType;

class PropertyStatus extends EnumType
{
    public function __construct()
    {
        $this->attributes = [
            'name'   => 'property_status',
            'values' => Status::toArray()
        ];
    }
}
