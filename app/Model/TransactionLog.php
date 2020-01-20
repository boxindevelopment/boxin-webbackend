<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionLog extends Model
{
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'user_id',
        'transaction_type',
        'order_id',
        'status',
        'location_warehouse',
        'location_pickup',
        'datetime_pickup',
        'types_of_box_space_small_id',
        'space_small_or_box_id',
        'amount'
    ];

    public function order()
    {
        if($this->transaction_type == 'start storing'){
            return $this->belongsTo('App\Model\Order', 'order_id', 'id');
        } else if($this->transaction_type == 'take') {
            return $this->belongsTo('App\Model\OrderTake', 'order_id', 'id');
        } else if($this->transaction_type == 'back warehouse'){
            return $this->belongsTo('App\Model\OrderBackWarehouse', 'order_id', 'id');
        } else if($this->transaction_type == 'extend'){
            return $this->belongsTo('App\Model\ExtendOrderDetail', 'order_id', 'id');
        } else if($this->transaction_type == 'terminate'){
            return $this->belongsTo('App\Model\ReturnBoxes', 'order_id', 'id');
        }
        return null;
    }
    public function boxOrSmallSpace()
    {
        if($this->types_of_box_space_small_id == 1){
            return $this->belongsTo('App\Model\Box', 'space_small_or_box_id', 'id');
        } else {
            return $this->belongsTo('App\Model\SpaceSmall', 'space_small_or_box_id', 'id');
        }
        return null;
    }
}
