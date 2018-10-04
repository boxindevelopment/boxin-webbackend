<?php

namespace App;

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

  public function getRoleAttribute()
  {
    return $this->getRoleNames()->first();
  }

}
