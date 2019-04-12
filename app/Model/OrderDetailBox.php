<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetailBox extends Model
{
    protected $table = 'order_detail_boxes';

    protected $fillable = [
        'order_detail_id', 'item_name', 'item_image', 'note'
    ];

    public function order_detail()
    {
        return $this->belongsTo('App\Model\OrderDetail', 'order_detail_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id', 'id');
    }

    public function change_box()
    {
        return $this->hasMany('App\Model\ChangeBox', 'order_detail_box_id', 'id');
    }

    public function getUrlAttribute()
    {
        if (!empty($this->item_image)) {
            return asset(config('image.url.detail_item_box') . $this->item_image);
        }

        return null;
    }

    public function getImagesAttribute()
    {
      $DEV_URL = 'https://boxin-dev-order.azurewebsites.net/images/detail_item_box/';
      $PROD_URL = 'https://boxin-prod-order.azurewebsites.net/images/detail_item_box/';

      $url = (env('DB_DATABASE') == 'coredatabase') ? $DEV_URL : $PROD_URL;

      $image = $this->item_image;
      return $url . $image;
    }

}
