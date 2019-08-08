<?php
declare(strict_types=1);

namespace App\GraphQL\Enums;

use App\Enums\PropertyMediaType as Type;
use Rebing\GraphQL\Support\EnumType;

class PropertyMediaType extends EnumType
{
    public function __construct()
    {
        $this->attributes = [
            'name'   => 'property_media_type',
            'values' => Type::toArray()
        ];
    }
}
