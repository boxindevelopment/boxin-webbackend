<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = 'payments';

    protected $fillable = [
        'order_id', 
        'user_id', 
        'payment_type', 
        'bank', 
        'amount', 
        'status_payment', 
        'status_id',
        'image_transfer',
        'id_name'
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

    public function getImageAttribute()
    {
      $DEV_URL = 'https://boxin-dev-order.azurewebsites.net/images/payment/order/';
      $PROD_URL = 'https://boxin-prod-order.azurewebsites.net/images/payment/order/';
      
      $url = (env('DB_DATABASE') == 'coredatabase') ? $DEV_URL : $PROD_URL;

      $image = $this->image_transfer;
<<<<<<< HEAD
      $image_source = $url . $image;
=======
      $image_source = asset('images/payment/order') . '/' . $image;
>>>>>>> 5932553c52173cfcda2f9216fda98cc055e3cf56
      return $image_source;
    }

}