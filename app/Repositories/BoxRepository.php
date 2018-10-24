<?php

namespace App\Repositories;

use App\Model\Box;
use App\Model\AdminCity;
use App\Repositories\Contracts\BoxRepository as BoxRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class BoxRepository implements BoxRepositoryInterface
{
    protected $model;

    public function __construct(Box $model)
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
            $boxes = $this->model->where('deleted_at', NULL)->orderBy('updated_at', 'DESC')->orderBy('id','DESC')->get();
        }else if(Auth::user()->roles_id == 2){
            $admin = AdminCity::where('user_id', Auth::user()->id)->first();
            $boxes = $this->model->select('boxes.*')
            ->leftJoin('spaces', 'spaces.id', '=', 'boxes.space_id')
            ->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id')
            ->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id')
            ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
            ->where('spaces.deleted_at', NULL)
            ->where('areas.city_id', $admin->city_id)
            ->orderBy('updated_at', 'DESC')->orderBy('id','DESC')->get();
        }
        return $boxes;
    }

    public function getById($id)
    {
        return $this->model->where('deleted_at', NULL)->where('id', $id)->get();
    }

    public function getCount($args = [])
    {
        return $this->model->where('name', 'like', $args['searchValue'].'%')->count();
    }
    public function getData($args = [])
    {

        $data = $this->model->select()
                ->orderBy($args['orderColumns'], $args['orderDir'])
                ->where('name', 'like', '%'.$args['searchValue'].'%')
                ->skip($args['start'])
                ->take($args['length'])
                ->get();

        return $data->toArray();

    }

    public function getEdit($id)
    {
        $data = $this->model->select(array('boxes.*', DB::raw('(cities.id) as city_id'),  DB::raw('(areas.id) as area_id'), DB::raw('(warehouses.id) as warehouse_id')))
                ->leftJoin('spaces', 'spaces.id', '=', 'boxes.space_id')
                ->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id')
                ->leftJoin('areas', 'areas.id', '=' ,'warehouses.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('boxes.id', $id)
                ->get();
                
        return $data;
    }
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(Box $box, $data)
    {
        return $box->update($data);
    }

    public function delete(Box $box)
    {
        return $box->delete();
    }
}