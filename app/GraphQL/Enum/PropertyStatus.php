<?php

namespace App\GraphQL\Enum;

use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Enums\PropertyStatus as Status;

class PropertyStatus extends GraphQLType
{
    protected $enumObject = true;

    protected $attributes;

    public function __construct($attributes = [])
    {
        $this->attributes = [
            'name' => 'property_status',
            'values' => Status::toArray()
        ];
        parent::__construct($attributes);
    }
}
