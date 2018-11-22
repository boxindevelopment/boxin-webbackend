<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminArea extends Model
{

    protected $table = 'admins';

    protected $fillable = [
        'user_id', 'area_id',
    ];

    public function area()
    {
        return $this->belongsTo('App\Model\Area', 'area_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
}