<?php
namespace App\GraphQL\Filters;

class CityFilter extends BaseFilter
{
    public function stateID(int $id) :void
    {
        $this->builder->where('state_id', '=', $id);
    }
}
