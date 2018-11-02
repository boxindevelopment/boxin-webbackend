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
        $admin = AdminCity::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();
        $data = $data->select('warehouses.id', 'warehouses.name', 'warehouses.area_id', 'warehouses.lat', 'warehouses.long', 'warehouses.id_name');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('warehouses.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->orderBy('warehouses.updated_at', 'DESC')->orderBy('warehouses.id','DESC');
        $data = $data->get();
        return $data;
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
        $data = $this->model->select(array('warehouses.*', 
            DB::raw('(cities.id) as city_id'), DB::raw('(cities.id_name) as city_id_name'),
            DB::raw('(areas.id) as area_id'), DB::raw('(areas.id_name) as area_id_name')))
                ->leftJoin('areas', 'areas.id', '=' ,'warehouses.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('warehouses.id', $id)
                ->first();
                
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