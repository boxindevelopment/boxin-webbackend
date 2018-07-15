<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $table = 'spaces';
    protected $fillable = [
        'warehouse_id', 'name'
    ];

    public function warehouse()
    {
        return $this->belongsTo('App\Entities\Warehouse', 'warehouse_id');
    }

}
