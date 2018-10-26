<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReturnBoxes extends Model
{
    protected $table = 'return_boxes';

    protected $dates = ['date'];

    protected $fillable = [
        'order_detail_id', 'types_of_pickup_id', 'address', 'longitute', 'latitude', 'date', 'time', 'time_pickup', 'note', 'status_id', 'deliver_fee', 'driver_name', 'driver_phone'
    ];

    public function order_detail()
    {
        return $this->belongsTo('App\Model\OrderDetail', 'order_detail_id', 'id');
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
