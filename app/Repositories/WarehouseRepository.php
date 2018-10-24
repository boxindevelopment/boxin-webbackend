<?php

namespace App\Repositories;

use App\Model\Warehouse;
use App\Model\AdminCity;
use App\Repositories\Contracts\WarehouseRepository as WarehouseRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class WarehouseRepository implements WarehouseRepositoryInterface
{
    protected $model;

    public function __construct(Warehouse $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
    
    public function all()
    {
        if(Auth::user()->roles_id == 3){
            $warehouse = $this->model->where('deleted_at', NULL)->orderBy('updated_at', 'DESC')->orderBy('id','DESC')->get();
        }else if(Auth::user()->roles_id == 2){
            $admin = AdminCity::where('user_id', Auth::user()->id)->first();
            $warehouse = $this->model->select('warehouses.*')
            ->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id')
            ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
            ->where('warehouses.deleted_at', NULL)
            ->where('areas.city_id', $admin->city_id)
            ->orderBy('updated_at', 'DESC')->orderBy('id','DESC')->get();
        }
        return $warehouse;
    }

    public function getCount($args = [])
    {
        return $this->model->where('name', 'like', $args['searchValue'].'%')->count();
    }
    public function getData($args = [])
    {

        $warehouse = $this->model->select()
                ->orderBy($args['orderColumns'], $args['orderDir'])
                ->where('name', 'like', '%'.$args['searchValue'].'%')
                ->skip($args['start'])
                ->take($args['length'])
                ->get();

        return $warehouse->toArray();

    }

    public function getSelectByArea($area_id)
    {

        $warehouse = $this->model->select()->where('area_id', $area_id)->where('deleted_at', NULL)->orderBy('name')->get();

        return $warehouse;

    }

    public function getSelectAll($args = [])
    {

        $warehouse = $this->model->select()->where('deleted_at', NULL)->orderBy('name')->get();

        return $warehouse;

    }

    public function getEdit($id)
    {
        $data = $this->model->select(array('warehouses.*', DB::raw('(cities.id) as city_id')))
                ->leftJoin('areas', 'areas.id', '=' ,'warehouses.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('warehouses.id', $id)
                ->get();
                
        return $data;
    }
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(Warehouse $warehouse, $data)
    {
        return $warehouse->update($data);
    }

    public function delete(Warehouse $warehouse)
    {
        return $warehouse->delete();
    }
}