<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = 'payments';

    protected $fillable = [
        'order_id', 'user_id', 'date_time', 'payment_type', 'payment_credit_card_id', 'amount', 'status_payment', 'status_id'
    ];

    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'order_id', 'id');
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