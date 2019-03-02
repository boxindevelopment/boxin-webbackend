<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChangeBox extends Model
{
    protected $table = 'change_boxes';

    protected $dates = ['date'];

    protected $fillable = [
        'order_detail_box_id', 'order_detail_id', 'types_of_pickup_id', 'address', 'date', 'time_pickup', 'note', 'status_id', 'deliver_fee', 'driver_name', 'driver_phone',
    ];

    public function change_details()
    {
       return $this->hasMany('App\Model\ChangeBoxDetail', 'change_box_id', 'id');
    }
    
    public function order_detail()
    {
       return $this->hasOne('App\Model\OrderDetail', 'id', 'order_detail_id');
    }

    public function order_detail_box()
    {
        return $this->belongsTo('App\Model\OrderDetailBox', 'order_detail_box_id', 'id');
    }

    public function type_pickup()
    {
        return $this->belongsTo('App\Model\TypePickup', 'types_of_pickup_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\Status', 'status_id', 'id');
    }

}
