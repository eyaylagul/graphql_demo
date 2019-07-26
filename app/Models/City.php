<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\GraphQLSortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City findByCountryCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City findByStateCode($code)
 */
class City extends Model
{
    use Filterable, GraphQLSortable;

    public $timestamps = false;
    public $sortable = [
        'id',
        'lat',
        'lng',
        'name',
    ];
    protected $table = 'city';
    protected $fillable = ['name', 'lat', 'lng', 'state_id'];
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function state() :BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function scopeFindByStateCode($query, $code)
    {
        return $query->leftJoin('state', 'state.id', '=', 'city.state_id')
            ->where('state.code', $code);
    }

    public function scopeFindByCountryCode($query, $code)
    {
        return $query->leftJoin('country', 'country.id', '=', 'state.country_id')
            ->where('country.code', $code);
    }
}
