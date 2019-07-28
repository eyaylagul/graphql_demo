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
 */
class CityAlias extends Model
{
    use Filterable, GraphQLSortable;

    public $timestamps = false;
    public $sortable = [
        'id',
        'name'
    ];
    protected $table = 'city_alias';
    protected $fillable = ['name', 'city_id'];
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function city() :BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
