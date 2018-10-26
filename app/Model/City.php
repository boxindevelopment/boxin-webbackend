<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $table = 'cities';

    protected $fillable = [
        'name', 'id_name'
    ];

    public function area()
    {
        return $this->hasMany('App\Model\Area', 'city_id', 'id');
    }

    public function admin_city()
  	{
      	return $this->hasMany('App\Model\AdminCity', 'city_id', 'id');
  	}

    public function price()
    {
        return $this->hasMany('App\Model\Price', 'city_id', 'id');
    }
}