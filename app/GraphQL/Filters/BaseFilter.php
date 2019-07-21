<?php
namespace App\GraphQL\Filters;

class BaseFilter extends QueryFilter
{
    /**
     * @param string $field
     * @param array  $options
     */
    public function range(string $field, array $options) :void
    {
        if (isset($options['gte'])) {
            $this->builder->where($field, '>=', $options['gte']);
        }

        if (isset($options['gt'])) {
            $this->builder->where($field, '>', $options['gt']);
        }

        if (isset($options['lt'])) {
            $this->builder->where($field, '<', $options['lt']);
        }

        if (isset($options['lte'])) {
            $this->builder->where($field, '<=', $options['lte']);
        }

        if (isset($options['empty']) && $options['empty'] === true) {
            $this->builder->whereNull($field);
        }

        if (isset($options['empty']) && $options['empty'] ===  false) {
            $this->builder->whereNotNull($field);
        }
    }

    public function createdAt(array $options) :void
    {
        $this->range('created_at', $options);
    }

    public function updatedAt(array $options) :void
    {
        $this->range('updated_at', $options);
    }

    public function id(array $ids) :void
    {
        $this->builder->find($ids);
    }

    public function name(string $name) :void
    {
        $this->builder->where('name', 'iLIKE', "%$name%");
    }
}
