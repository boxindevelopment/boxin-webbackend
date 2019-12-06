<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regency extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    //

    /**
     * [user Relationship to User]
     * @return [type] [description]
     */
    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

}
