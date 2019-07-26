<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\GraphQLSortable;

/**
 * App\Models\PropertyType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType apiFilter(\App\GraphQL\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType apiSortable($args = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType whereName($value)
 * @mixin \Eloquent
 */
class PropertyType extends Model
{
    use Filterable, GraphQLSortable;

    protected $table = 'property_type';
    public $timestamps = false;

    public $sortable = [
        'id',
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'description'
    ];

    protected $guarded = ['id'];
}
