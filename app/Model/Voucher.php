<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    protected $table = 'vouchers';

    protected $fillable = [
        'name', 'code', 'description', 'start_date', 'end_date', 'value', 'min_amount', 'max_value', 'type_voucher', 'image', 'status_id', 'term_condition'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function status()
  	{
      	return $this->belongsTo('App\Model\Status', 'status_id', 'id');
  	}
}
