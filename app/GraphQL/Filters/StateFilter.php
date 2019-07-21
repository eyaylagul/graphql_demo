<?php
namespace App\GraphQL\Filters;

class StateFilter extends BaseFilter
{
    public function countryID(int $id) :void
    {
        $this->builder->where('country_id', '=', $id);
    }
}
