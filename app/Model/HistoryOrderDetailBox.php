<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HistoryOrderDetailBox extends Model
{
  
  protected $table = 'history_order_detail_boxes';

  protected $fillable = [
    'order_detail_id',
    'category_id',
    'item_name',
    'item_image',
    'note',
    'action'
  ];

  public function category()
  {
    return $this->belongsTo('App\Model\Category', 'category_id', 'id');
  }
  
  public function order_detail()
  {
    return $this->belongsTo('App\Model\OrderDetail', 'order_detail_id', 'id');
  }

  public function getImageAttribute()
  {
    $DEV_URL = 'https://boxin-dev-order.azurewebsites.net/images/history/';
    $PROD_URL = 'https://boxin-prod-order.azurewebsites.net/images/history/';
    $url = (env('DB_DATABASE') == 'coredatabase') ? $DEV_URL : $PROD_URL;
    $image = $this->item_image;
    return $url . $image;
  }

}
