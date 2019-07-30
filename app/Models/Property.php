<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\GraphQLSortable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Property
 *
 * @property int                                                                       $id
 * @property string                                                                    $status       available - is visible in the system. disabled - by admin, owner or editor.
 *                                       moderating - user publish adv. editor should check it
 *                                       payment_pending - user publish and maybe moderator check but waiting payment
 * @property \Illuminate\Support\Carbon|null                                           $expire_at    when property will be expired
 * @property \Illuminate\Support\Carbon|null                                           $available_at when customer can move in
 * @property \Illuminate\Support\Carbon|null                                           $created_at
 * @property \Illuminate\Support\Carbon|null                                           $updated_at
 * @property string                                                                    $title
 * @property string                                                                    $description
 * @property int|null                                                                  $price
 * @property int|null                                                                  $price_max
 * @property string                                                                    $address
 * @property string                                                                    $postcode
 * @property int                                                                       $square_feet
 * @property bool                                                                      $pets
 * @property float                                                                     $lat
 * @property float                                                                     $lng
 * @property int                                                                       $property_type_id
 * @property int                                                                       $city_id
 * @property array|null                                                                $features
 * @property array|null                                                                $initiator
 * @property int                                                                       $user_id
 * @property-read \App\Models\City                                                     $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropertyMedia[] $media
 * @property-read \App\Models\PropertyType                                             $type
 * @property-read \App\Models\User                                                     $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property apiFilter(\App\GraphQL\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property apiSortable($args = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereAvailableAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereInitiator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property wherePets($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property wherePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property wherePropertyTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereSquareFeet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereUserId($value)
 * @mixin \Eloquent
 * @property int                                                                       $bedrooms
 * @property int                                                                       $bathrooms
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property whereBedrooms($value)
 */
class Property extends Model
{
    use Filterable, GraphQLSortable;

    protected $table = 'property';
    protected $dates = ['created_at', 'updated_at', 'expire_at', 'available_at'];
    protected $casts = [
        'features'  => 'json',
//        'initiator' => 'json',
        'pets'      => 'boolean'
    ];

    // default parameter for field
//    protected $attributes = [
//        'features' => '[1, 2]' // todo set custom features
//    ];

    /* todo check when start implement UI*/
    public $sortable = [
        'id',
        'status',
        'title',
        'description',
        'price',
        'max_price',
        'address',
        'postcode',
        'lat',
        'lng'
    ];

    // todo price may be money type. consider it in future
    protected $fillable = [
        'status',
        'title',
        'description',
        'price',
        'max_price',
        'address',
        'postcode',
        'lat',
        'lng',
        'initiator',
        'features',
        'bedrooms',
        'bathrooms'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id');
    }

    public function type(): HasOne
    {
        return $this->hasOne(PropertyType::class, 'id');
    }

    /* todo check it */
    public function media(): HasMany
    {
        return $this->hasMany(PropertyMedia::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
