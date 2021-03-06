<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypeSize extends Model
{

    protected $table = 'types_of_size';

    protected $fillable = [
        'types_of_box_room_id', 'name', 'size', 'image', 
    ];

    public function type_box_room()
    {
        return $this->belongsTo('App\Model\TypeBoxRoom', 'types_of_box_room_id', 'id');
    }
    
    public function order_detail()
    {
        return $this->hasMany('App\Model\OrderDetail', 'types_of_size_id', 'id');
    }

    public function price()
    {
        return $this->hasMany('App\Model\Price', 'types_of_size_id', 'id');
    }

    public function box()
    {
        return $this->hasMany('App\Model\Box', 'types_of_size_id', 'id');
    }

    public function space()
    {
        return $this->hasMany('App\Model\Space', 'types_of_size_id', 'id');
    }
}