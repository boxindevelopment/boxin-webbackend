<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddItem extends Model
{
    protected $table = 'add_items';

    protected $fillable = [
      'add_item_box_id',
      'category_id', 
      'item_name', 
      'item_image',
      'note',
    ];

    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id', 'id');
    }

    public function add_item_box()
    {
        return $this->belongsTo('App\Model\AddItemBox', 'add_item_box_id', 'id');
    }

    public function getImageAttribute()
    {
      $DEV_URL = 'https://boxin-dev-order.azurewebsites.net/images/additem/';
      $PROD_URL = 'https://boxin-prod-order.azurewebsites.net/images/additem/';
      $url = (env('DB_DATABASE') == 'coredatabase') ? $DEV_URL : $PROD_URL;
      $image = $this->item_image;
      return $url . $image;
    }

}
