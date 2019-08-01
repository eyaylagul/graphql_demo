<?php
declare(strict_types=1);

namespace App\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;

class SortDirection extends EnumType
{
    protected $attributes = [
        'name' => 'SortDirection',
        'values' => [
            'asc' => 'asc',
            'desc' => 'desc',
        ],
    ];
}
