<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryFee extends Model
{

    protected $table = 'delivery_fee';

    protected $fillable = [
        'area_id', 'fee'
    ];

    public function area()
    {
        return $this->belongsTo('App\Model\Area', 'area_id', 'id');
    }

}