<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypeBoxRoom extends Model
{

    protected $table = 'types_of_box_room';

    protected $fillable = [
        'name'
    ];

    public function order_detail()
    {
        return $this->hasMany('App\Model\OrderDetail', 'types_of_box_room_id', 'id');
    }

    public function price()
    {
        return $this->hasMany('App\Model\Price', 'types_of_box_room_id', 'id');
    }

    public function type_size()
    {
        return $this->hasMany('App\Model\TypeSize', 'types_of_box_room_id', 'id');
    }

}