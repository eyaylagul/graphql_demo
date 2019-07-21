<?php
namespace App\GraphQL\Filters;

class RoleFilter extends BaseFilter
{
    public function displayName(string $displayName) :void
    {
        $this->builder->where('display_name', 'iLIKE', "%$displayName%");
    }
}
