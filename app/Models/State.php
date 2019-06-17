<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\GraphQLSortable;

/**
 * App\Models\State
 *
 * @property int                      $id
 * @property string                   $name
 * @property int                      $country_id
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State whereName($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State apiFilter(\App\GraphQL\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State apiSortable($args = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\State filter(\App\Filters\QueryFilter $filter)
 */
class State extends Model
{
    use Filterable;

    public $sortable = [
        'id',
        'name'
    ];
    public $timestamps = false;
    protected $table = 'state';
    protected $fillable = ['country_id', 'name'];
    protected $guarded = ['id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
