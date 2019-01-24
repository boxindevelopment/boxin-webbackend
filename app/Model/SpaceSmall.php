<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpaceSmall extends Model
{

    protected $fillable = [
        'code_space_small', 'shelves_id', 'types_of_size_id', 'name', 'barcode', 'location', 'size', 'price', 'status_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

   public function shelves()
    {
        return $this->belongsTo('App\Model\Shelves', 'shelves_id', 'id');
    }

    public function type_size()
    {
        return $this->belongsTo('App\Model\TypeSize', 'types_of_size_id');
    }

    public function order_detail()
    {
        return $this->hasMany('App\Model\OrderDetail', 'room_or_box_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\Status', 'status_id', 'id');
    }

}
