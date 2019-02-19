<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExtendOrderDetail extends Model
{
    protected $table = 'extend_order_details';

    protected $fillable = [
        'order_detail_id', 
        'order_id', 
        'extend_duration', 
        'remaining_duration', 
        'amount', 
        'end_date_before', 
        'payment_expired', 
        'payment_status_expired', 
        'status_id',
        'user_id'
    ];

    public function user()
    {
       return $this->hasOne('App\Model\User', 'id', 'user_id');
    }
    
    public function status()
    {
       return $this->hasOne('App\Model\Status', 'id', 'status_id');
    }

    public function order()
    {
       return $this->hasOne('App\Model\Order', 'id', 'order_id');
    }

    public function order_detail()
    {
       return $this->hasOne('App\Model\OrderDetail', 'id', 'order_detail_id');
    }


}
