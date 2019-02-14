<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

    protected $table = 'banners';

    protected $fillable = [
        'name', 'image', 'status_id'
    ];

    public function status()
  	{
      	return $this->belongsTo('App\Model\Status', 'status_id', 'id');
  	}
}