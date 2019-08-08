<?php
namespace App\GraphQL\Filters;

class PropertyMediaFilter extends BaseFilter
{
    public function isPrimary(bool $val) :void
    {
        $this->builder->where('is_primary', '=', $val);
    }

//    public function isLocal(string $displayName) :void
//    {
//        $this->builder->where('display_name', 'iLIKE', "%$displayName%");
//    }
//
//    public function type(string $displayName) :void
//    {
//        $this->builder->where('display_name', 'iLIKE', "%$displayName%");
//    }
}
