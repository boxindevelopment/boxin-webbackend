<?php

namespace App\Repositories;

use App\Model\Space;
use App\Model\AdminArea;
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
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();
        $data = $data->select('spaces.id', 'spaces.name', 'spaces.area_id', 'spaces.lat', 'spaces.long', 'spaces.id_name', 'spaces.status_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'spaces.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('spaces.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
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
        $data = $this->model->select(array('spaces.*', 
            DB::raw('(cities.id) as city_id'), DB::raw('(cities.id_name) as city_id_name'),
            DB::raw('(areas.id) as area_id'), DB::raw('(areas.id_name) as area_id_name')))
                ->leftJoin('areas', 'areas.id', '=' ,'spaces.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('spaces.id', $id)
                ->first();
                
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