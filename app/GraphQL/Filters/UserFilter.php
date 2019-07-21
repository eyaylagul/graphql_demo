<?php
namespace App\GraphQL\Filters;

class UserFilter extends BaseFilter
{
    public function email(string $val) :void
    {
        $this->builder->where('email', 'iLIKE', "%$val%");
    }

    public function firstName(string $val) :void
    {
        $this->builder->where('first_name', 'iLIKE', "%$val%");
    }

    public function lastName(string $val) :void
    {
        $this->builder->where('last_name', 'iLIKE', "%$val%");
    }

    public function notify(bool $val) :void
    {
        $this->builder->where('notify', '=', $val);
    }

    public function cityID(array $val) :void
    {
        $this->builder->whereIn('city_id', $val);
    }

    public function status(string $val) :void
    {
        $this->builder->where('status', '=', $val);
    }
}
