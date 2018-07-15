<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';
    protected $fillable = [
        'area_id', 'name', 'lat', 'long'
    ];

    public function areaWarehouse()
    {
        return $this->belongsTo('App\Entities\Area', 'area_id');
    }

}
