<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'space_id', 'total', 'qty', 'status_id' 
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }

    public function space()
    {
        return $this->belongsTo('App\Model\Space', 'space_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\Status', 'status_id', 'id');
    }

    public function order_detail()
    {
        return $this->hasMany('App\Model\OrderDetail', 'order_id', 'id');
    }

    public function pickup_order()
    {
        return $this->hasMany('App\Model\PickupOrder', 'order_id', 'id');
    }

}