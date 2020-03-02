<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderTakePayment extends Model
{

    protected $fillable = [
      'order_detail_id',
      'order_take_id',
      'user_id',
      'payment_type',
      'bank',
      'amount',
      'status_id',
      'id_name',
      'midtrans_url',
      'midtrans_status',
      'midtrans_start_transaction',
      'midtrans_expired_transaction',
      'midtrans_response'
    ];

    public function order_detail()
    {
        return $this->belongsTo('App\Model\OrderDetail', 'order_detail_id', 'id');
    }

    public function order_take()
    {
        return $this->belongsTo('App\Model\OrderTake', 'order_take_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\Status', 'status_id', 'id');
    }

}
