<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddItemBox extends Model
{
  protected $table = 'add_item_boxes';

  protected $fillable = [
      'order_detail_id',  
      'types_of_pickup_id', 
      'address', 
      'date', 
      'time_pickup', 
      'note', 
      'status_id', 
      'deliver_fee', 
      'driver_name', 
      'driver_phone'
  ];

  public function order_detail()
  {
      return $this->belongsTo('App\Model\OrderDetail', 'order_detail_id', 'id');
  }

  public function type_pickup()
  {
      return $this->belongsTo('App\Model\TypePickup', 'types_of_pickup_id', 'id');
  }

  public function status()
  {
      return $this->belongsTo('App\Model\Status', 'status_id', 'id');
  }

  public function items()
  {
     return $this->hasMany('App\Model\AddItem', 'add_item_box_id', 'id');
  }
  
}
