<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{

    protected $table = 'spaces';

    protected $fillable = [
        'warehouse_id', 'name', 'id_name'
    ];

    public function warehouse()
    {
        return $this->belongsTo('App\Model\Warehouse', 'warehouse_id', 'id');
    }

    public function room()
    {
        return $this->hasMany('App\Model\Room', 'space_id', 'id');
    }

    public function box()
    {
        return $this->hasMany('App\Model\Box', 'space_id', 'id');
    }

    public function order_detail()
    {
        return $this->hasMany('App\Model\OrderDetail', 'space_id', 'id');
    }

}