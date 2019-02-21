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
      $image = $this->image_transfer;
      $image_source = asset('images/no-image.jpg');
      // $image_source = null;
      if (strlen($image) > 0) {
          if (file_exists(public_path('images/payment/order') . '/' . $image)) {
              $image_source =public_path('images/payment/order') . '/' . $image;
          }
      }
      return $image_source;
    }

}