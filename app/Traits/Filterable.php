<?php

namespace App\Traits;

use App\GraphQL\Filters\QueryFilter as ApiFilter;

trait Filterable
{
    public function scopeApiFilter($query, ApiFilter $filter): void
    {
        $filter->apply($query);
    }
}
