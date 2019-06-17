<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GraphQLSortable;

/**
 * App\Models\Country
 *
 * @property int    $id
 * @property string $code
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereName($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country apiSortable($args = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country apiFilter(\App\GraphQL\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country filter(\App\Filters\QueryFilter $filter)
 */
class Country extends Model
{
    use Filterable;

    public $timestamps = false;
    public $sortable = [
        'id',
        'code',
        'name'
    ];
    protected $table = 'country';
    protected $fillable = ['code', 'name'];
    protected $guarded = ['id'];
}
