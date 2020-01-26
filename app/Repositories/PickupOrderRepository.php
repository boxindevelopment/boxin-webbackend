<?php

namespace App\Repositories;

use App\Model\PickupOrder;
use App\Model\AdminArea;
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
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();
        $data = $data->select('pickup_orders.id', 'pickup_orders.order_id', 'pickup_orders.date', 'pickup_orders.types_of_pickup_id', 'pickup_orders.status_id', 'users.first_name',  'users.last_name', 'order_details.id_name', 'order_details.place');
        $data = $data->leftJoin('orders','orders.id','=','pickup_orders.order_id');
        $data = $data->leftJoin('order_details','order_details.order_id','=','orders.id');
        $data = $data->leftJoin('users','users.id','=','orders.user_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('orders.area_id', $admin->area_id);
        }
        $data = $data->where('pickup_orders.status_id', '!=', 4);
        // $data = $data->orderBy('orders.created_at', 'DESC');
        $data = $data->distinct('pickup_orders.order_id');
        $data = $data->orderBy('pickup_orders.date', 'DESC');
        $data = $data->get();
        return $data;
    }

    public function getCount($args = [])
    {
        $query = $this->model->query();
        $query->leftJoin('orders','orders.id','=','pickup_orders.order_id');
        $query->leftJoin('order_details','order_details.order_id','=','orders.id');
        $query->leftJoin('users','users.id','=','orders.user_id');
        $query->leftJoin('types_of_pickup','types_of_pickup.id','=','pickup_orders.types_of_pickup_id');
        if(Auth::user()->roles_id == 2){
            $query->where('orders.area_id', $admin->area_id);
        }
        $query->where('pickup_orders.status_id', '!=', 4);
        $query->where('order_details.id_name', 'like', '%'.$args['searchValue'].'%');

        return $query->count();
    }
    public function getData($args = [])
    {

        $query = $this->model->query();
        $query->select('pickup_orders.id', 'pickup_orders.order_id', 'pickup_orders.date',
                        'pickup_orders.types_of_pickup_id', 'pickup_orders.status_id', 'users.first_name',
                        'users.last_name', 'order_details.id_name', 'order_details.place',
                        'status.name as status_name', 'types_of_pickup.name as types_of_pickup_name');
        $query->leftJoin('orders','orders.id','=','pickup_orders.order_id');
        $query->leftJoin('order_details','order_details.order_id','=','orders.id');
        $query->leftJoin('users','users.id','=','orders.user_id');
        $query->leftJoin('status','status.id','=','orders.status_id');
        $query->leftJoin('types_of_pickup','types_of_pickup.id','=','pickup_orders.types_of_pickup_id');
        if(Auth::user()->roles_id == 2){
            $query->where('orders.area_id', $admin->area_id);
        }
        $query->where('pickup_orders.status_id', '!=', 4);
        $query->where('order_details.id_name', 'like', '%'.$args['searchValue'].'%');
        $query->distinct('pickup_orders.order_id');
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

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
