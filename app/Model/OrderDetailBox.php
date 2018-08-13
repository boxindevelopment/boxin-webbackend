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

    public function getUrlAttribute()
    {
        if (!empty($this->item_image)) {
            return asset(config('image.url.detail_item_box') . $this->item_image);
        }

        return null;
    }
}