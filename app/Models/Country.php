<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GraphQLSortable;
use \Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 */
class Country extends Model
{
    use Filterable, GraphQLSortable;

    public $timestamps = false;
    public $sortable = [
        'id',
        'code',
        'name'
    ];
    protected $table = 'country';
    protected $fillable = ['code', 'name'];
    protected $guarded = ['id'];

    /**
     * Usage
     * Country::where('name', 'Canada')
        ->first()
        ->cities()
        ->where('state.name', 'British Columbia')
        ->where('city.name', 'Vancouver')
        ->get();
     * @return HasManyThrough
     */
    public function cities() :HasManyThrough
    {
        return $this->hasManyThrough(City::class, State::class);
    }

}
