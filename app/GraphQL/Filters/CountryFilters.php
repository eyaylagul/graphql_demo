<?php
namespace App\GraphQL\Filters;

class CountryFilters extends BaseFilter
{
    public function code(string $code) :void
    {
        $this->builder->where('code', 'iLIKE', "%$code%");
    }
}
