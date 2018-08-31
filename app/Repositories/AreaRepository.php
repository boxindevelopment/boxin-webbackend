<?php

namespace App\Repositories;

use App\Model\Area;
use App\Repositories\Contracts\AreaRepository as AreaRepositoryInterface;

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
        return $this->model->where('deleted_at', NULL)->orderBy('updated_at', 'DESC')->orderBy('id','DESC')->get();
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