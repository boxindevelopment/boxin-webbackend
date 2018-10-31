<?php

namespace App\Repositories;

use App\Model\Area;
use App\Model\AdminCity;
use App\Repositories\Contracts\AreaRepository as AreaRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AreaRepository implements AreaRepositoryInterface
{
    protected $model;

    public function __construct(Area $model)
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
        $data = $data->select('areas.id', 'areas.name', 'areas.city_id', 'areas.id_name');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->orderBy('areas.updated_at', 'DESC')->orderBy('id','DESC');
        $data = $data->get();
        return $data;
    }

    public function getCount($args = [])
    {
        return $this->model->where('name', 'like', $args['searchValue'].'%')->count();
    }
    public function getData($args = [])
    {

        $area = $this->model->select()
                ->orderBy($args['orderColumns'], $args['orderDir'])
                ->where('name', 'like', '%'.$args['searchValue'].'%')
                ->skip($args['start'])
                ->take($args['length'])
                ->get();

        return $area->toArray();

    }

    public function getSelect($city_id)
    {

        $area = $this->model->select()->where('city_id', $city_id)->where('deleted_at', NULL)->orderBy('name')->get();

        return $area;

    }

    public function getSelectAll($args = [])
    {

        $area = $this->model->select()->where('deleted_at', NULL)->orderBy('name')->get();

        return $area;

    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(Area $area, $data)
    {
        return $area->update($data);
    }

    public function delete(Area $area)
    {
        return $area->delete();
    }
}