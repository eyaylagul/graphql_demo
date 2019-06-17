<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\GraphQLSortable;
use Laratrust\Models\LaratrustPermission;

/**
 * App\Models\Permission
 *
 * @property int                                                              $id
 * @property string                                                           $name
 * @property string|null                                                      $display_name
 * @property string|null                                                      $description
 * @property \Illuminate\Support\Carbon|null                                  $created_at
 * @property \Illuminate\Support\Carbon|null                                  $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission apiFilter(\App\GraphQL\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission apiSortable($args = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission filter(\App\Filters\QueryFilter $filter)
 */
class Permission extends LaratrustPermission
{
    use Filterable;

    public $sortable = [
        'id',
        'name',
        'display_name',
        'description',
        'created_at',
        'updated_at',
    ];
    protected $table = 'permission';
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
}
