<?php

namespace App\Repositories;

use App\Model\User;
use App\Model\AdminCity;
use App\Repositories\Contracts\UserRepository as UserRepositoryInterface;
use DB;

class UserRepository implements UserRepositoryInterface
{
    protected $model;
    protected $admin;

    public function __construct(User $model, AdminCity $admin)
    {
        $this->model = $model;
        $this->admin = $admin;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
    
    public function findAdmin($id)
    {
        return $this->admin->findOrFail($id);
    }

    public function getByRoles($roles_id)
    {
        return $this->model->where('deleted_at', NULL)->where('roles_id', $roles_id)->orderBy('first_name', 'asc')->get();
    }

    public function getSelectAllnotAdmin()
    {
        return $this->model->select()->where('roles_id', '!=', 2)->where('roles_id', '!=', 3)->where('deleted_at', NULL)->orderBy('first_name', 'asc')->get();
    }

    public function getSelectAllnotSuperadmin()
    {
        return $this->model->select()->where('roles_id', '!=', 3)->where('deleted_at', NULL)->orderBy('first_name', 'asc')->get();
    }

    public function getAllAdminCity()
    {
        return $this->admin->get();
    }

    public function getEdit($id)
    {
        $data = $this->admin->select(array('admin_city.*', 
                    DB::raw('(users.first_name) as first_name'), 
                    DB::raw('(users.last_name) as last_name'), 
                    DB::raw('(cities.name) as city_name')
                ))
                ->leftJoin('users', 'users.id', '=' ,'admin_city.user_id')
                ->leftJoin('cities', 'cities.id', '=', 'admin_city.city_id')
                ->where('admin_city.id', $id)
                ->first();                
        return $data;
    }
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(User $user, $data)
    {
        return $user->update($data);
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}