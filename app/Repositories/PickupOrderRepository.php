<?php

namespace App\Repositories;

use App\Model\PickupOrder;
use App\Model\AdminCity;
use App\Repositories\Contracts\PickupOrderRepository as PickupOrderRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class PickupOrderRepository implements PickupOrderRepositoryInterface
{
    protected $model;

    public function __construct(PickupOrder $model)
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
        $data = $data->select('pickup_orders.id', 'pickup_orders.types_of_pickup_id', 'pickup_orders.status_id', 'users.first_name',  'users.last_name');
        $data = $data->leftJoin('orders','orders.id','=','pickup_orders.order_id');
        $data = $data->leftJoin('users','users.id','=','orders.user_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('spaces', 'spaces.id', '=', 'orders.space_id');
            $data = $data->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id');
            $data = $data->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id');
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('pickup_orders.status_id', '!=', 4);
        $data = $data->orderBy('pickup_orders.status_id', 'DESC')->orderBy('id', 'ASC');
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
    
    public function update(PickupOrder $order, $data)
    {
        return $order->update($data);
    }

    public function delete(PickupOrder $order)
    {
        return $order->delete();
    }
}