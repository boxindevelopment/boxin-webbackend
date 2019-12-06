<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
  use Notifiable, HasRoles, SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'first_name', 'last_name', 'phone', 'email', 'password', 'roles_id', 'status'
  ];

  protected $hidden = [
      'password', 'remember_token',
  ];

  protected $primaryKey = 'id';

  public function roles()
  {
      return $this->belongsTo('App\Model\Roles', 'roles_id', 'id');
  }

  public function order()
  {
      return $this->hasMany('App\Model\Order', 'user_id', 'id');
  }

  public function admin()
  {
      return $this->hasMany('App\Model\AdminArea', 'user_id', 'id');
  }

  public function payment()
  {
      return $this->hasMany('App\Model\Payment', 'user_id', 'id');
  }

 public function addresses()
 {
     return $this->hasMany('App\Model\UserAddress');
 }

}
