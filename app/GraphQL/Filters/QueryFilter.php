<?php
namespace App\GraphQL\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    /** @var Builder $builder */
    protected $builder;
    // argument from graphql input object
    protected $args = [];

    public function __construct(array $args = [])
    {
        $this->args = $args;
    }

    /**
     * @param Builder $builder
     */
    public function apply(Builder $builder) :void
    {
        $this->builder = $builder;

        if (isset($this->args['filter'])) {
            foreach ($this->args['filter'] as $field => $value) {
                $method = Str::camel($field);
                if (method_exists($this, $method)) {
                    $this->$method($value); // call method
                }
            }
        }
    }
}
