<?php

namespace App\Repositories;

use App\Model\Price;
use App\Repositories\Contracts\PriceRepository as PriceRepositoryInterface;
use DB;
use App\Model\AdminCity;
use Illuminate\Support\Facades\Auth;

class PriceRepository implements PriceRepositoryInterface
{
    protected $model;

    public function __construct(Price $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getById($id)
    {
        return $this->model->where('id', $id)->get();
    }
    
    public function all($box_or_room_id)
    {
        $admin = AdminCity::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();
        $data = $data->select('prices.*');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('cities', 'cities.id', '=', 'prices.city_id');
            $data = $data->where('prices.city_id', $admin->city_id);
        }
        $data = $data->where('types_of_box_room_id', $box_or_room_id);
        $data = $data->orderBy('id');
        $data = $data->get();
        return $data;
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
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(Price $price, $data)
    {
        return $price->update($data);
    }

    public function delete(Price $price)
    {
        return $price->delete();
    }
}