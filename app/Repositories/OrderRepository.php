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
        $admin = AdminCity::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();
        $data = $data->select('orders.id', 'user_id', 'space_id', 'total', 'status_id', 'orders.created_at');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('spaces', 'spaces.id', '=', 'orders.space_id');
            $data = $data->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id');
            $data = $data->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id');
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('orders.deleted_at', NULL);
        $data = $data->orderBy('id','DESC');
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
    
    public function update(Order $order, $data)
    {
        return $order->update($data);
    }

    public function delete(Order $order)
    {
        return $order->delete();
    }
}