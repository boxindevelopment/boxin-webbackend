<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Boxes extends Model
{
    protected $table = 'boxes';
    protected $fillable = [
        'name', 'barcode', 'location', 'size', 'price'
    ];

}
