<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'name'
    ];

    public function areaWarehouse()
    {
        return $this->hasMany('App\Entities\Area', 'city_warehouse_id');
    }

}
