<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Rebing\GraphQL\Error\ValidationError;

trait GraphQLSortable
{
    /**
     * @param Builder $query
     * @param array   $args
     *
     * @throws ValidationError
     */
    public function scopeApiSortable(Builder $query, array $args = []): void
    {
        // check if user write input sort
        if (isset($args['sort']['sort_by'])) {
            if (!isset($args['sort']['sort_by']) && isset($args['sort']['type'])) {
                throw new ValidationError('missing field name for sorting');
            }
            if (!isset($args['sort']['type'])) {
                throw new ValidationError('missing type direction');
            }
            if (in_array($args['sort']['sort_by'], $this->sortable, true) === false) {
                throw new ValidationError('invalid field name for sorting');
            }

            $query->orderBy($args['sort']['sort_by'], $args['sort']['type']);
        }
    }
}
