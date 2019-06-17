<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\GraphQLSortable;

/**
 * App\Models\City
 *
 * @property int                    $id
 * @property string                 $name
 * @property float                  $lat
 * @property float                  $lng
 * @property int                    $state_id
 * @property-read \App\Models\State $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City apiFilter(\App\GraphQL\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereStateId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City apiSortable($args = [])
 */
class City extends Model
{
    use Filterable;
    public $timestamps = false;
    public $sortable = [
        'id',
        'name',
    ];
    protected $table = 'city';
    protected $fillable = ['name', 'lat', 'lng', 'state_id'];
    protected $guarded = ['id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function countrySortable($query, $direction)
    {
        return $query->leftJoin('state', 'city.state_id', '=', 'state.id')
            ->leftJoin('country', 'country.id', '=', 'state.country_id')
            ->orderBy('country.name', $direction)
            ->select(['state.*', 'country.*', 'city.*']);
    }
}
