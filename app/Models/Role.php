<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\GraphQLSortable;
use Laratrust\Models\LaratrustRole;

/**
 * App\Models\Role
 *
 * @property int                                                                    $id
 * @property string                                                                 $name
 * @property string|null                                                            $display_name
 * @property string|null                                                            $description
 * @property \Illuminate\Support\Carbon|null                                        $created_at
 * @property \Illuminate\Support\Carbon|null                                        $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role apiFilter(\App\GraphQL\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role apiSortable($args = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role filter(\App\Filters\QueryFilter $filter)
 */
class Role extends LaratrustRole
{
    use Filterable, GraphQLSortable;

    public $sortable = [
        'id',
        'name',
        'display_name',
        'description',
        'created_at',
        'updated_at',
    ];
    protected $table = 'role';
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
}
