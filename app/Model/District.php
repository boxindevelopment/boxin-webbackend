<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    //

    /**
     * [user Relationship to User]
     * @return [type] [description]
     */
    public function villages()
    {
        return $this->hasMany('App\Model\Village');
    }

    public function regency()
    {
        return $this->belongsTo('App\Model\Regency');
    }

}
