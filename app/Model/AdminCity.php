<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminCity extends Model
{

    protected $table = 'admin_city';

    protected $fillable = [
        'user_id', 'city_id',
    ];

    public function city()
    {
        return $this->belongsTo('App\Model\City', 'city_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
}