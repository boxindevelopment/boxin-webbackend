<?php

namespace App\Repositories;

use App\Model\Warehouse;
use App\Repositories\Contracts\WarehouseRepository as WarehouseRepositoryInterface;
use DB;

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
        return $this->model->where('deleted_at', NULL)->orderBy('updated_at', 'DESC')->orderBy('id','DESC')->get();
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

    public function getSelect($args = [])
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