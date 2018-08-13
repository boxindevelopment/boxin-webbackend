<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'space_id', 'name', 'types_of_size_id', 
    ];

    public function space()
    {
        return $this->belongsTo('App\Model\Space', 'space_id', 'id');
    }

    public function type_size()
    {
        return $this->belongsTo('App\Model\TypeSize', 'types_of_size_id', 'id');
    }
    
    public function order_detail()
    {
        return $this->hasMany('App\Model\OrderDetail', 'room_or_box_id', 'id');
    }

}