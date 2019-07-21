<?php
namespace App\GraphQL\Filters;

class PermissionFilter extends BaseFilter
{
    public function displayName(string $displayName) :void
    {
        $this->builder->where('display_name', 'iLIKE', "%$displayName%");
    }
}
