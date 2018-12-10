<?php

namespace App\Repositories;

use App\Model\Area;
use App\Model\AdminArea;
use App\Repositories\Contracts\AreaRepository as AreaRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use DB;

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
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();
        $data = $data->select('areas.id', 'areas.name', 'areas.city_id', 'areas.id_name');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->orderBy('areas.updated_at', 'DESC')->orderBy('id','DESC');
        $data = $data->get();
        return $data;
    }

    public function insertPrice($area_id)
    {
        DB::table('prices')->insert([
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 1, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 1, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 1, 'types_of_duration_id' => 7, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 1, 'types_of_duration_id' => 8, 'price' => 0, ],

            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 2, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 2, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 2, 'types_of_duration_id' => 7, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 2, 'types_of_duration_id' => 8, 'price' => 0, ],

            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 3, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 3, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 3, 'types_of_duration_id' => 7, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 1, 'types_of_size_id' => 3, 'types_of_duration_id' => 8, 'price' => 0, ],

            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 4, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 4, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 4, 'types_of_duration_id' => 7, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 4, 'types_of_duration_id' => 8, 'price' => 0, ],

            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 5, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 5, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 5, 'types_of_duration_id' => 7, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 5, 'types_of_duration_id' => 8, 'price' => 0, ],
            

            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 6, 'types_of_duration_id' => 2, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 6, 'types_of_duration_id' => 3, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 6, 'types_of_duration_id' => 7, 'price' => 0, ],
            [ 'area_id' => $area_id, 'types_of_box_room_id' => 2, 'types_of_size_id' => 6, 'types_of_duration_id' => 8, 'price' => 0, ],
        ]);
        return true;
    }
    
    public function insertDeliveryFee($area_id)
    {
        DB::table('delivery_fee')->insert([
            [ 'area_id' => $area_id, 'fee' => 0, ],
        ]);
        return true;
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