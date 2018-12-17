<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    protected $table = 'vouchers';

    protected $fillable = [
        'name', 'code', 'description', 'start_date', 'end_date', 'value', 'type_voucher', 'image', 'status_id'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function status()
  	{
      	return $this->belongsTo('App\Model\Status', 'status_id', 'id');
  	}
}