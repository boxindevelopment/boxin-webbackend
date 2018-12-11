<?php

namespace App\Repositories;

use App\Model\Price;
use App\Repositories\Contracts\PriceRepository as PriceRepositoryInterface;
use DB;
use App\Model\AdminArea;
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
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();
        if(Auth::user()->roles_id == 2){
            $data = $data->where('prices.area_id', $admin->area_id);
        }
        $data = $data->where('types_of_box_room_id', $box_or_room_id);        
        $data = $data->where('prices.deleted_at', NULL);
        $data = $data->orderBy('id');
        $data = $data->get();
        return $data;
    }

    public function checkPrice($type, $type_size, $area_id)
    {
        $data = $this->model->where('types_of_size_id', $type_size)->where('types_of_box_room_id', $type)->where('area_id', $area_id)->first();
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

    public function getEdit($id)
    {
        $data = $this->model->select(array('prices.*', 
            DB::raw('(cities.id) as city_id'), DB::raw('(cities.id_name) as city_id_name'),  
            DB::raw('(areas.id) as area_id'), DB::raw('(areas.id_name) as area_id_name')))
                ->leftJoin('areas', 'areas.id', '=' ,'prices.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('prices.id', $id)
                ->first();
                
        return $data;
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