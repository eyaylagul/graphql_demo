<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\GraphQLSortable;

class PropertyType extends Model
{
    use Filterable, GraphQLSortable;

    protected $table = 'property_type';
    public $timestamps = false;

    public $sortable = [
        'id',
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'description'
    ];

    protected $guarded = ['id'];
}
