<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChangeBoxDetail extends Model
{
  protected $table = 'change_box_details';

  protected $fillable = [
      'change_box_id', 
      'order_detail_box_id'
  ];

  public function change_box()
  {
     return $this->hasOne('App\Model\ChangeBox', 'id', 'change_box_id');
  }

  public function order_detail_box()
  {
     return $this->hasOne('App\Model\OrderDetailBox', 'id', 'order_detail_box_id');
  }

}
