<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'user_id',
        'order_id',
        'title',
        'notifiable_id',
        'data',
        'read_at',
        'send_user',
    ];

    /**
     * [consultant_id Relationship to User]
     * @return [type] [description]
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * [consultant_id Relationship to User]
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'send_user');
    }

}