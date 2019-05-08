<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
      'user_id',
      'area_id',
      'total',
      'qty',
      'status_id',
      'payment_expired',
      'payment_status_expired', // 0 = false, 1 = true
      'voucher_id',
      'voucher_amount'
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo('App\Model\Area', 'area_id', 'id');
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
        return $this->hasOne('App\Model\PickupOrder', 'order_id', 'id');
    }

    public function voucher()
    {
        return $this->belongsTo('App\Model\Voucher', 'voucher_id');
    }

}
