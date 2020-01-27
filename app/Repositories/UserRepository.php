<?php

namespace App\Repositories;

use App\Model\User;
use App\Model\AdminArea;
use App\Repositories\Contracts\UserRepository as UserRepositoryInterface;
use DB;

class UserRepository implements UserRepositoryInterface
{
    protected $model;
    protected $admin;

    public function __construct(User $model, AdminArea $admin)
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

    public function getAll()
    {
        return $this->model->where('deleted_at', NULL)->orderBy('first_name', 'asc')->get();
    }

    public function getCount($args = [])
    {
        $query = $this->model->query();
        $query->where('first_name', 'like', '%'.$args['searchValue'].'%');
        return $query->count();
    }

    public function getData($args = [])
    {

        $query = $this->model->query();
        $query->select('users.*', 'roles.name as role_name');
        $query->join('roles', 'roles.id', 'users.roles_id');
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('first_name', 'like', '%'.$args['searchValue'].'%');
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data;

    }

    public function getAdminByRoles($roles_id)
    {
        return $this->admin->select('admins.*')->leftJoin('users', 'users.id', '=' ,'admins.user_id')->where('users.roles_id', $roles_id)->where('users.deleted_at', NULL)->orderBy('first_name', 'asc')->get();
    }

    public function getSuperadmin()
    {
        return $this->model->where('roles_id', 3)->where('status', 1)->where('deleted_at', NULL)->orderBy('first_name', 'asc')->get();
    }

    public function getSelectAll()
    {
        return $this->model->select()->where('roles_id', 1)->where('deleted_at', NULL)->orderBy('first_name', 'asc')->get();
    }

    public function getSelectAllForAdmin()
    {
        return $this->model->select()->where('roles_id', '!=', 3)->where('roles_id', '!=', 4)->where('status', 1)->where('deleted_at', NULL)->orderBy('first_name', 'asc')->get();
    }

    public function getSelectAllForSuperadmin()
    {
        return $this->model->select()->where('roles_id', '!=', 2)->where('roles_id', '!=', 4)->where('status', 1)->where('deleted_at', NULL)->orderBy('first_name', 'asc')->get();
    }

    public function getSelectAllForFinance()
    {
        return $this->model->select()->where('roles_id', '!=', 2)->where('roles_id', '!=', 3)->where('status', 1)->where('deleted_at', NULL)->orderBy('first_name', 'asc')->get();
    }

    public function getEdit($id)
    {
        $data = $this->admin->select(array('admins.*',
                    DB::raw('(users.roles_id) as roles_id'),
                    DB::raw('(cities.id) as city_id'), DB::raw('(cities.id_name) as city_id_name'),
                    DB::raw('(areas.id) as area_id'), DB::raw('(areas.id_name) as area_id_name')
                ))
                ->leftJoin('users', 'users.id', '=' ,'admins.user_id')
                ->leftJoin('areas', 'areas.id', '=', 'admins.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('admins.id', $id)
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
