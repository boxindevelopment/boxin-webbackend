<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Village extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    //

    /**
     * [user Relationship to User]
     * @return [type] [description]
     */
    public function address()
    {
        return $this->hasMany('App\Model\UserAddress');
    }

    public function district()
    {
        return $this->belongsTo('App\Model\District');
    }

}
