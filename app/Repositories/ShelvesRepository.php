<?php

namespace App\Repositories;

use App\Model\Shelves;
use App\Model\AdminArea;
use App\Repositories\Contracts\ShelvesRepository as ShelvesRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class ShelvesRepository implements ShelvesRepositoryInterface
{
    protected $model;

    public function __construct(Shelves $model)
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
        $data = $data->select('shelves.*');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'shelves.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('shelves.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->orderBy('shelves.updated_at', 'DESC')->orderBy('shelves.id','DESC');
        $data = $data->get();
        return $data;
    }

    public function getCount($args = [])
    {
        return $this->model
                    ->join("areas", "areas.id", "shelves.area_id")
                    ->where('shelves.name', 'like', $args['searchValue'].'%')
                    ->count();
    }
    public function getData($args = [])
    {
        $shelves = $this->model->select('shelves.*', 'areas.name as area_name', DB::raw('(SUM(*) as sm_bx FROM boxes WHERE boxes.shelves_id = shelves.id ) as count_box'))
                ->join("areas", "areas.id", "shelves.area_id")
                ->orderBy($args['orderColumns'], $args['orderDir'])
                ->where('shelves.name', 'like', '%'.$args['searchValue'].'%')
                ->skip($args['start'])
                ->take($args['length'])
                ->get();

        return $shelves->toArray();
    }

    public function getSelectByArea($area_id)
    {
        $shelves = $this->model->select()->where('area_id', $area_id)->where('deleted_at', NULL)->orderBy('name')->get();

        return $shelves;
    }

    public function getSelectAll($args = [])
    {
        $data = $this->model->select()->where('deleted_at', NULL)->orderBy('name')->get();

        return $data;
    }

    public function getEdit($id)
    {
        $data = $this->model->select(array('shelves.*',
            DB::raw('(cities.id) as city_id'), DB::raw('(cities.id_name) as city_id_name'),
            DB::raw('(areas.id) as area_id'), DB::raw('(areas.id_name) as area_id_name')))
                ->leftJoin('areas', 'areas.id', '=' ,'shelves.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('shelves.id', $id)
                ->first();

        return $data;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Shelves $shelves, $data)
    {
        return $shelves->update($data);
    }

    public function delete(Shelves $shelves)
    {
        return $shelves->delete();
    }
}
