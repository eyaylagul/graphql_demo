<?php
namespace App\GraphQL\Filters;

class PropertyTypeFilter extends BaseFilter
{
    public function description(string $val) :void
    {
        $this->builder->where('description', 'iLIKE', "%$val%");
    }
}
