<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChangeBoxPayment extends Model
{

    protected $table = 'change_box_payments';

    protected $fillable = [
        'order_detail_id', 'user_id', 'payment_type', 'bank', 'amount', 'image_transfer', 'status_id', 'id_name'
    ];

    public function order_detail()
    {
        return $this->belongsTo('App\Model\OrderDetail', 'order_detail_id', 'id');
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
      $DEV_URL = 'https://boxin-dev-order.azurewebsites.net/images/payment/changebox/';
      $PROD_URL = 'https://boxin-prod-order.azurewebsites.net/images/payment/changebox/';

      $url = (env('DB_DATABASE') == 'coredatabase') ? $DEV_URL : $PROD_URL;

      $image = $this->image_transfer;
      $image_source = $url . $image;
      return $image_source;
    }

}
