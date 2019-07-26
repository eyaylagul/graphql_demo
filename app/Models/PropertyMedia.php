<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\GraphQLSortable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PropertyMedia
 *
 * @property int                             $id
 * @property string                          $path       where store file
 * @property string|null                     $description
 * @property int                             $position   needs to detect in which order show files
 * @property bool                            $is_primary when true is main property file
 * @property bool                            $is_local   file locally or external: http://
 * @property string                          $type
 * @property int                             $property_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property       $property
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia apiFilter(\App\GraphQL\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia apiSortable($args = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia whereIsLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyMedia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PropertyMedia extends Model
{
    use Filterable, GraphQLSortable;

    protected $table = 'property_media';
    protected $dates = ['created_at', 'updated_at'];


    protected $casts = [
        'is_primary' => 'boolean',
        'is_local'   => 'boolean'
    ];

    public $sortable = [
        'id',
        'path',
        'description',
        'position',
        'is_primary',
        'is_local',
        'type',
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'path',
        'description',
        'position',
        'is_primary',
        'is_local',
        'type'
    ];

    protected $guarded = ['id'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
