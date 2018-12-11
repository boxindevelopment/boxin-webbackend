<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    protected $table = 'areas';

    protected $fillable = [
        'city_id', 'name', 'id_name', 'latitude', 'longitude'
    ];

    public function city()
    {
        return $this->belongsTo('App\Model\City', 'city_id', 'id');
    }

    public function admin()
    {
        return $this->hasMany('App\Model\Admin', 'area_id', 'id');
    }

    public function price()
    {
        return $this->hasMany('App\Model\Price', 'area_id', 'id');
    }

    public function order()
    {
        return $this->hasMany('App\Model\Order', 'area_id', 'id');
    }

    public function deliveryFee()
    {
        return $this->hasMany('App\Model\DeliveryFee', 'area_id', 'id');
    }
}