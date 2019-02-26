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

}
