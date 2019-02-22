<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id', 'types_of_duration_id', 'room_or_box_id', 'types_of_box_room_id', 'types_of_size_id', 'name', 'duration', 'amount', 'start_date', 'end_date', 'status_id', 'id_name'
    ];

    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'order_id', 'id');
    }

    public function box()
    {
        return $this->belongsTo('App\Model\Box', 'room_or_box_id', 'id');
    }

    public function space()
    {
        return $this->belongsTo('App\Model\SpaceSmall', 'room_or_box_id', 'id');
    }

    public function type_box_room()
    {
        return $this->belongsTo('App\Model\TypeBoxRoom', 'types_of_box_room_id', 'id');
    }

    public function type_size()
    {
        return $this->belongsTo('App\Model\TypeSize', 'types_of_size_id', 'id');
    }

    public function type_duration()
    {
        return $this->belongsTo('App\Model\TypeDuration', 'types_of_duration_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\Status', 'status_id', 'id');
    }

    public function order_detail_box()
    {
        return $this->hasMany('App\Model\OrderDetailBox', 'order_detail_id', 'id');
    }

}
