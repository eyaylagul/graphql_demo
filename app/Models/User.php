<?php

namespace App\Models;

use App\Enums\UserStatus;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;
use Laratrust\Traits\LaratrustUserTrait;
use App\Traits\Filterable;
use App\Traits\GraphQLSortable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @mixin \Eloquent
 * @property string                                                                                                         $id
 * @property string                                                                                                         $name
 * @property string                                                                                                         $email
 * @property string|null                                                                                                    $email_verified_at
 * @property string                                                                                                         $password
 * @property string|null                                                                                                    $remember_token
 * @property \Illuminate\Support\Carbon|null                                                                                $created_at
 * @property \Illuminate\Support\Carbon|null                                                                                $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[]                                         $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[]                                               $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRoleIs($role = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User apiFilter(\App\GraphQL\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User apiSortable($defaultParameters = null)
 * @property string                                                                                                         $first_name
 * @property string                                                                                                         $last_name
 * @property array|null                                                                                                     $address
 * @property array|null                                                                                                     $phone phones and fax numbers
 * @property string                                                                                                         $status
 * @property bool                                                                                                           $notify
 * @property int|null                                                                                                       $city_id
 * @property-read \App\Models\City|null                                                                                     $city
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatus($value)
 */
class User extends Authenticatable implements JWTSubject
{
    use LaratrustUserTrait, Notifiable, Filterable, GraphQLSortable;

    protected $table = 'user';
    protected $dates = ['created_at', 'updated_at'];

    public $sortable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'notify',
        'status',
        'created_at',
        'updated_at',
        'email_verified_at'
    ];
    /**
     * Define by default values to field
     * @var array
     */
    protected $attributes = [
        'status' => UserStatus::AVAILABLE
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone'   => 'array',
        'address' => 'array',
        'notify'  => 'boolean',
    ];

    public $statuses = [UserStatus::AVAILABLE, UserStatus::BLOCKED];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'phone', 'address', 'email', 'password', 'notify', 'city_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function setPasswordAttribute(string $val): void
    {
        if (Hash::needsRehash($val)) {
            $this->attributes['password'] = Hash::make($val);
        } else {
            $this->attributes['password'] = $val;
        }
    }

    /**
     * To store json in field we have to check it on null, transform to json, and write
     *
     * @param array|null $val
     */
    public function setAddressAttribute(array $val = null)
    {
        $this->attributes['address'] = !empty(array_filter($val)) ? json_encode($val) : null;
    }

    public function setPhoneAttribute(array $val = null)
    {
        $this->attributes['phone'] = !empty(array_filter($val)) ? json_encode($val) : null;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
