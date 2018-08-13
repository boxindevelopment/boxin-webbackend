<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypeDuration extends Model
{

    protected $table = 'types_of_duration';

    protected $fillable = [
        'name'
    ];

    public function order_detail()
    {
        return $this->hasMany('App\Model\OrderDetail', 'types_of_duration_id', 'id');
    }
}