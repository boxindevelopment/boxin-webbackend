<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnBox extends Model
{
    use SoftDeletes;

    protected $table = 'return_box';

    protected $fillable = [
        'order_detail_id', 'type_pickup_id', 'address', 'longitute', 'latitude', 'date', 'time', 'note', 'status_id', 'deliver_fee', 'driver_name', 'driver_phone'
    ];

    public function order_detail()
    {
        return $this->belongsTo('App\Model\OrderDetail', 'order_detail_id', 'id');
    }

    public function type_pickup()
    {
        return $this->belongsTo('App\Model\TypePickup', 'type_pickup_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\Status', 'status_id', 'id');
    }

}