<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupOrder extends Model
{
    use SoftDeletes;

    protected $table = 'pickup_orders';

    protected $fillable = [
        'order_id', 'types_of_pickup_id', 'address', 'longitute', 'latitude', 'date', 'time', 'note', 'status_id', 'pickup_fee', 'driver_name', 'driver_phone'
    ];

    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'order_id', 'id');
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
