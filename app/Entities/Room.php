<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $fillable = [
        'space_id', 'name'
    ];

    public function space()
    {
        return $this->belongsTo('App\Entities\Space', 'space_id');
    }

}
