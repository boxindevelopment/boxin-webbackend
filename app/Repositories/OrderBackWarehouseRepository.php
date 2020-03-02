<?php

namespace App\Repositories;

use App\Model\OrderBackWarehouse;
use App\Model\AdminArea;
use App\Repositories\Contracts\OrderBackWarehouseRepository as OrderBackWarehouseRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderBackWarehouseRepository;

class OrderBackWarehouseRepository implements OrderBackWarehouseRepositoryInterface
{
    protected $model;

    public function __construct(OrderBackWarehouse $model)
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

    public function all()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $order = $this->model->query();
        $order = $order->select('order_back_warehouses.id', 'order_back_warehouses.order_detail_id', 'order_back_warehouses.types_of_pickup_id', 'order_back_warehouses.status_id', 'order_back_warehouses.created_at', 'order_back_warehouses.date', 'order_back_warehouses.time_pickup');
        $order = $order->leftJoin('order_details','order_details.id','=','order_back_warehouses.order_detail_id');
        $order = $order->leftJoin('orders','orders.id','=','order_details.order_id');
        if(Auth::user()->roles_id == 2){
            $order = $order->where('orders.area_id', $admin->area_id);
        }
        $order = $order->orderBy('status_id','DESC');
        $order = $order->orderBy('id','DESC')->get();

        return $order;
    }

    public function getCount($args = [])
    {
        $query = $this->model->query();
        $query->leftJoin('order_details','order_details.id','=','order_back_warehouses.order_detail_id');
        $query->leftJoin('orders','orders.id','=','order_details.order_id');
        $query->leftJoin('users','users.id','=','orders.user_id');
        $query->leftJoin('status','status.id','=','order_back_warehouses.status_id');
        if(Auth::user()->roles_id == 2){
            $query->where('orders.area_id', $admin->area_id);
        }
        $query->where('users.first_name', 'like', '%'.$args['searchValue'].'%');
        return $query->count();
    }

    public function getData($args = [])
    {

        $query = $this->model->query();
        $query->select('order_back_warehouses.*', 'users.first_name',  'users.last_name', 'status.name as status_name');
        $query->leftJoin('order_details','order_details.id','=','order_back_warehouses.order_detail_id');
        $query->leftJoin('orders','orders.id','=','order_details.order_id');
        $query->leftJoin('users','users.id','=','orders.user_id');
        $query->leftJoin('status','status.id','=','order_back_warehouses.status_id');
        if(Auth::user()->roles_id == 2){
            $query->where('orders.area_id', $admin->area_id);
        }
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('users.first_name', 'like', '%'.$args['searchValue'].'%');
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data;

    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(OrderBackWarehouse $backWarehouse, $data)
    {
        return $backWarehouse->update($data);
    }

    public function delete(OrderBackWarehouse $backWarehouse)
    {
        return $backWarehouse->delete();
    }
}
