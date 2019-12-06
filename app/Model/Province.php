<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    //

    /**
     * [regencies Relationship to Regency]
     * @return [type] [description]
     */
    public function regencies()
    {
        return $this->hasMany('App\Models\Regency');
    }

}
