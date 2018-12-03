<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';

    protected $fillable = [
        'name', 'value', 'unit', 'description'
    ];
    
}