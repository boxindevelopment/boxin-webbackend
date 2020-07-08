<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelves extends Model
{
    use SoftDeletes;

    protected $table = 'shelves';

    protected $fillable = [
        'name', 'area_id', 'code_shelves'
    ];

    public function area()
    {
        return $this->belongsTo('App\Model\Area', 'area_id');
    }

    public function box()
    {
        return $this->hasMany('App\Model\Box', 'shelves_id', 'id');
    }

    public function order_detail()
    {
        return $this->hasMany('App\Model\OrderDetail', 'room_or_box_id', 'id');
    }

}
