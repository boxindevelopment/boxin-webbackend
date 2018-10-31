<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    protected $table = 'areas';

    protected $fillable = [
        'city_id', 'name', 'id_name'
    ];

    public function city()
    {
        return $this->belongsTo('App\Model\City', 'city_id', 'id');
    }

    public function warehouse()
    {
        return $this->hasMany('App\Model\Warehouse', 'area_id', 'id');
    }
}