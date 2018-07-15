<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    
    protected $table = 'area';
    protected $fillable = [
        'city_warehouse_id', 'name'
    ];

    public function cityWarehouse()
    {
        return $this->belongsTo('App\Entities\Cities', 'city_warehouse_id');
    }

}
