<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    protected $table = 'vouchers';

    protected $fillable = [
        'name', 'code', 'description', 'start_date', 'end_date', 'value', 'type_voucher'
    ];

}