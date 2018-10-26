<?php

namespace App\Repositories;

use App\Model\Space;
use App\Model\AdminCity;
use App\Repositories\Contracts\SpaceRepository as SpaceRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class SpaceRepository implements SpaceRepositoryInterface
{
    protected $model;

    public function __construct(Space $model)
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
        $data = $data->select('spaces.id', 'spaces.name', 'spaces.warehouse_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id');
            $data = $data->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id');
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('spaces.deleted_at', NULL);
        $data = $data->orderBy('spaces.updated_at', 'DESC')->orderBy('spaces.id','DESC');
        $data = $data->get();
        return $data;
    }

    public function getCount($args = [])
    {
        return $this->model->where('name', 'like', $args['searchValue'].'%')->count();
    }
    public function getData($args = [])
    {

        $space = $this->model->select()
                ->orderBy($args['orderColumns'], $args['orderDir'])
                ->where('name', 'like', '%'.$args['searchValue'].'%')
                ->skip($args['start'])
                ->take($args['length'])
                ->get();

        return $space->toArray();

    }

    public function getSelectByWarehouse($warehouse_id)
    {

        $space = $this->model->select()->where('warehouse_id', $warehouse_id)->where('deleted_at', NULL)->orderBy('name')->get();

        return $space;

    }

    public function getSelectAll($args = [])
    {

        $space = $this->model->select()->where('deleted_at', NULL)->orderBy('name')->get();

        return $space;

    }

    public function getEdit($id)
    {
        $data = $this->model->select(array('spaces.*', DB::raw('(cities.id) as city_id'),  DB::raw('(areas.id) as area_id')))
                ->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id')
                ->leftJoin('areas', 'areas.id', '=' ,'warehouses.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('spaces.id', $id)
                ->get();
                
        return $data;
    }
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(Space $space, $data)
    {
        return $space->update($data);
    }

    public function delete(Space $space)
    {
        return $space->delete();
    }
}