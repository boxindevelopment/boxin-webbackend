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

    public function getPrice($types_of_box_room_id, $types_of_size_id, $types_of_duration_id, $area_id)
    {
        $price =  Price::where('types_of_box_room_id', $types_of_box_room_id)
            ->where('types_of_size_id', $types_of_size_id)
            ->where('types_of_duration_id', $types_of_duration_id)
            ->where('area_id', $area_id)
            ->first();

        return $price;

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

    public function getCount($args = [])
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $query = $this->model->query();
        $query->join('types_of_box_room', 'types_of_box_room.id', 'prices.types_of_box_room_id');
        $query->join('types_of_duration', 'types_of_duration.id', 'prices.types_of_duration_id');
        $query->join('types_of_size', 'types_of_size.id', 'prices.types_of_size_id');
        if(Auth::user()->roles_id == 2){
            $query->where('prices.area_id', $admin->area_id);
        }
        $query->where('prices.types_of_box_room_id', $args['box_or_room_id']);
        $query->where('types_of_size.name', 'like', '%'.$args['searchValue'].'%');
        $query->where('prices.deleted_at', NULL);
        return $query->count();
    }

    public function getData($args = [])
    {

        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $query = $this->model->query();
        $query->select('prices.*', 'types_of_box_room.name as types_of_size_name', 'types_of_duration.name as duration',
                        'types_of_duration.alias', 'types_of_size.name', 'areas.name as area_name');
        $query->join('types_of_box_room', 'types_of_box_room.id', 'prices.types_of_box_room_id');
        $query->join('types_of_duration', 'types_of_duration.id', 'prices.types_of_duration_id');
        $query->join('types_of_size', 'types_of_size.id', 'prices.types_of_size_id');
        $query->join('areas', 'areas.id', 'prices.area_id');
        if(Auth::user()->roles_id == 2){
            $query->where('prices.area_id', $admin->area_id);
        }
        $query->where('prices.types_of_box_room_id', $args['box_or_room_id']);
        $query->where('prices.deleted_at', NULL);
        $query->where('types_of_size.name', 'like', '%'.$args['searchValue'].'%');
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data;

    }

    public function checkPrice($type, $type_size, $area_id)
    {
        $data = $this->model->where('types_of_size_id', $type_size)->where('types_of_box_room_id', $type)->where('area_id', $area_id)->first();
        return $data;
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
