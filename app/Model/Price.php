<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';

    protected $fillable = [
        'types_of_box_room_id', 'types_of_size_id', 'types_of_duration_id', 'price', 'city_id'
    ];

    public function type_box_room()
    {
        return $this->belongsTo('App\Model\TypeBoxRoom', 'types_of_box_room_id', 'id');
    }
    
    public function type_duration()
    {
        return $this->belongsTo('App\Model\TypeDuration', 'types_of_duration_id', 'id');
    }

    public function type_size()
    {
        return $this->belongsTo('App\Model\TypeSize', 'types_of_size_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Model\City', 'city_id', 'id');
    }
}