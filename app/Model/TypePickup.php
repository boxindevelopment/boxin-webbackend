<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypePickup extends Model
{

    protected $table = 'types_of_pickup';

    protected $fillable = [
        'name'
    ];

    public function pickup_order()
    {
        return $this->hasMany('App\Model\PickupOrder', 'types_of_pickup_id', 'id');
    }

    public function return_box()
    {
        return $this->hasMany('App\Model\ReturnBox', 'type_pickup_id', 'id');
    }
}