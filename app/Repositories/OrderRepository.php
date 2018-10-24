<?php

namespace App\Repositories;

use App\Model\Order;
use App\Model\AdminCity;
use App\Repositories\Contracts\OrderRepository as OrderRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class OrderRepository implements OrderRepositoryInterface
{
    protected $model;

    public function __construct(Order $model)
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
            $room = $this->model->where('deleted_at', NULL)->orderBy('status_id', 'ASC')->orderBy('id','ASC')->get();
        }else if(Auth::user()->roles_id == 2){
            $admin = AdminCity::where('user_id', Auth::user()->id)->first();
            $room = $this->model->select('orders.*')
            ->leftJoin('spaces', 'spaces.id', '=', 'orders.space_id')
            ->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id')
            ->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id')
            ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
            ->where('spaces.deleted_at', NULL)
            ->where('areas.city_id', $admin->city_id)
            ->orderBy('status_id', 'ASC')->orderBy('id','ASC')->get();
        }
        return $room;
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
        $data = $this->model->select(array('rooms.*', DB::raw('(cities.id) as city_id'),  DB::raw('(areas.id) as area_id'), DB::raw('(warehouses.id) as warehouse_id')))
                ->leftJoin('spaces', 'spaces.id', '=', 'rooms.space_id')
                ->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id')
                ->leftJoin('areas', 'areas.id', '=' ,'warehouses.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('rooms.id', $id)
                ->get();
                
        return $data;
    }
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(Order $order, $data)
    {
        return $order->update($data);
    }

    public function delete(Order $order)
    {
        return $order->delete();
    }
}