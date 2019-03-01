<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddItemBoxPayment extends Model
{
  protected $table = 'add_item_box_payments';

  protected $fillable = [
      'order_detail_id', 
      'user_id', 
      'payment_type', 
      'bank', 
      'amount', 
      'image_transfer', 
      'status_id', 
      'id_name',
      'add_item_box_id'
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

  public function add_item_box()
  {
      return $this->belongsTo('App\Model\AddItemBox', 'add_item_box_id', 'id');
  }

  public function getImageAttribute()
  {
    $DEV_URL = 'https://boxin-dev-order.azurewebsites.net/images/payment/additem/';
    $PROD_URL = 'https://boxin-prod-order.azurewebsites.net/images/payment/additem/';

    $url = (env('DB_DATABASE') == 'coredatabase') ? $DEV_URL : $PROD_URL;

    $image = $this->image_transfer;
    $image_source = $url . $image;
    return $image_source;
  }
  
}
