<?php

namespace App\Repositories;

use App\Model\City;
use App\Model\AdminCity;
use App\Repositories\Contracts\CityRepository as CityRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use DB;

class CityRepository implements CityRepositoryInterface
{
    protected $model;

    public function __construct(City $model)
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

        $city = $this->model->select()
                ->orderBy($args['orderColumns'], $args['orderDir'])
                ->where('name', 'like', '%'.$args['searchValue'].'%')
                ->skip($args['start'])
                ->take($args['length'])
                ->get();

        return $city->toArray();

    }

    public function getSelect($args = [])
    {
        if(Auth::user()->roles_id == 3){
            $city = $this->model->select()->where('deleted_at', NULL)->orderBy('name')->get();
        }else if(Auth::user()->roles_id == 2){
            $admin = AdminCity::where('user_id', Auth::user()->id)->first();
            $city = $this->model->select()->where('deleted_at', NULL)->where('id', $admin->city_id)->orderBy('name')->get();
        }
        return $city;
    }

    public function insertPrice($id_city)
    {
        DB::table('prices')->insert([
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 1, 'types_of_size_id' => 1, 'types_of_duration_id' => 1, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 1, 'types_of_size_id' => 1, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 1, 'types_of_size_id' => 1, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 1, 'types_of_size_id' => 2, 'types_of_duration_id' => 1, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 1, 'types_of_size_id' => 2, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 1, 'types_of_size_id' => 2, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 1, 'types_of_size_id' => 3, 'types_of_duration_id' => 1, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 1, 'types_of_size_id' => 3, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 1, 'types_of_size_id' => 3, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 2, 'types_of_size_id' => 4, 'types_of_duration_id' => 1, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 2, 'types_of_size_id' => 4, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 2, 'types_of_size_id' => 4, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 2, 'types_of_size_id' => 5, 'types_of_duration_id' => 1, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 2, 'types_of_size_id' => 5, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 2, 'types_of_size_id' => 5, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 2, 'types_of_size_id' => 6, 'types_of_duration_id' => 1, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 2, 'types_of_size_id' => 6, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'city_id' => $id_city, 'types_of_box_room_id' => 2, 'types_of_size_id' => 6, 'types_of_duration_id' => 3, 'price' => 0, ],
        ]);
        return true;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(City $city, $data)
    {
        return $city->update($data);
    }

    public function delete(City $city)
    {
        return $city->delete();
    }
}