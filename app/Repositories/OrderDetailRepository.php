<?php

namespace App\Repositories;

use App\Model\OrderDetail;
use App\Model\OrderDetailBox;
use App\Model\AdminArea;
use App\Repositories\Contracts\OrderDetailRepository as OrderDetailRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon;

class OrderDetailRepository implements OrderDetailRepositoryInterface
{
    protected $model;
    protected $detail_box;

    public function __construct(OrderDetail $model, OrderDetailBox $detail_box)
    {
        $this->model = $model;
        $this->detail_box = $detail_box;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function all()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();
        $data = $data->select('order_details.*', 'users.*');
        $data = $data->leftJoin('orders', 'orders.id', '=', 'order_details.order_id');
        $data = $data->leftJoin('users', 'users.id', '=', 'orders.user_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('orders.area_id', $admin->area_id);
        }
        $data = $data->where('order_details.status_id', 4);
        $data = $data->orderBy('order_details.id','DESC');
        $data = $data->get();
        return $data;
    }



    public function getCount($args = [])
    {
        $query = $this->model->query();
        $query->join("orders", "orders.id", "order_details.order_id");
        $query->join("users", "users.id", "orders.user_id");
        $query->join("status", "status.id", "orders.status_id");
        $query->join("types_of_duration", "types_of_duration.id", "order_details.types_of_duration_id");
        $query->where(function ($q) use ($args) {
                $q->where('users.first_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('users.last_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('order_details.id_name', 'like', '%'.$args['searchValue'].'%');
            });
        $query->where('order_details.status_id', 4);

        return $query->count();
    }

    public function getData($args = [])
    {

        $query = $this->model->query();
        $query->select('order_details.*', 'users.first_name', 'users.last_name', 'status.name as status_name', 'types_of_duration.alias as duration_alias');
        $query->join("orders", "orders.id", "order_details.order_id");
        $query->join("users", "users.id", "orders.user_id");
        $query->join("status", "status.id", "orders.status_id");
        $query->join("types_of_duration", "types_of_duration.id", "order_details.types_of_duration_id");
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('order_details.status_id', 4);
        $query->where(function ($q) use ($args) {
                $q->where('users.first_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('users.last_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('order_details.id_name', 'like', '%'.$args['searchValue'].'%');
            });
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data->toArray();

    }

    public function getOrderDetail($id)
    {
        $data = $this->model->query();
        $data = $data->select('order_details.*', 'users.*', 'pickup_orders.*', 'orders.*');
        $data = $data->leftJoin('orders', 'orders.id', '=', 'order_details.order_id');
        $data = $data->leftJoin('pickup_orders', 'pickup_orders.order_id', '=', 'orders.id');
        $data = $data->leftJoin('users', 'users.id', '=', 'orders.user_id');
        $data = $data->where('order_details.order_id', $id);
        $data = $data->first();
        return $data;
    }

    public function getDetailBox($id)
    {
        $data = $this->detail_box->query();
        $data = $data->select('order_detail_boxes.*');
        $data = $data->leftJoin('order_details', 'order_details.id', '=', 'order_detail_boxes.order_detail_id');
        $data = $data->where('order_details.order_id', $id);
        $data = $data->orderBy('order_detail_boxes.id', 'ASC');
        $data = $data->get();
        return $data;
    }


    public function getBoxCount($args = [])
    {
        $query = $this->model->query();
        $query->join("boxes", "boxes.id", "order_details.room_or_box_id");
        $query->join("orders", "orders.id", "order_details.order_id");
        $query->join("users", "users.id", "orders.user_id");
        $query->join("status", "status.id", "orders.status_id");
        $query->join("types_of_duration", "types_of_duration.id", "order_details.types_of_duration_id");
        $query->where(function ($q) use ($args) {
                $q->where('users.first_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('users.last_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('order_details.id_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('boxes.name', 'like', '%'.$args['searchValue'].'%');
            });
        $query->where('order_details.types_of_box_room_id', 1);

        return $query->count();
    }

    public function getBoxData($args = [])
    {

        $query = $this->model->query();
        $query->select('order_details.*', 'boxes.name as box_name', 'users.first_name', 'users.last_name', 'status.name as status_name', 'types_of_duration.alias as duration_alias');
        $query->join("boxes", "boxes.id", "order_details.room_or_box_id");
        $query->join("orders", "orders.id", "order_details.order_id");
        $query->join("users", "users.id", "orders.user_id");
        $query->join("status", "status.id", "orders.status_id");
        $query->join("types_of_duration", "types_of_duration.id", "order_details.types_of_duration_id");
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('order_details.types_of_box_room_id', 1);
        $query->where(function ($q) use ($args) {
                $q->where('users.first_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('users.last_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('order_details.id_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('boxes.name', 'like', '%'.$args['searchValue'].'%');
            });
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data->toArray();

    }


    public function getSpaceCount($args = [])
    {
        $query = $this->model->query();
        $query->join("space_smalls", "space_smalls.id", "order_details.room_or_box_id");
        $query->join("orders", "orders.id", "order_details.order_id");
        $query->join("users", "users.id", "orders.user_id");
        $query->join("status", "status.id", "orders.status_id");
        $query->join("types_of_duration", "types_of_duration.id", "order_details.types_of_duration_id");
        $query->where(function ($q) use ($args) {
                $q->where('users.first_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('users.last_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('order_details.id_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('space_smalls.name', 'like', '%'.$args['searchValue'].'%');
            });
        $query->where('order_details.types_of_box_room_id', 2);

        return $query->count();
    }

    public function getSpaceData($args = [])
    {

        $query = $this->model->query();
        $query->select('order_details.*', 'space_smalls.name as space_name', 'users.first_name', 'users.last_name', 'status.name as status_name', 'types_of_duration.alias as duration_alias');
        $query->join("space_smalls", "space_smalls.id", "order_details.room_or_box_id");
        $query->join("orders", "orders.id", "order_details.order_id");
        $query->join("users", "users.id", "orders.user_id");
        $query->join("status", "status.id", "orders.status_id");
        $query->join("types_of_duration", "types_of_duration.id", "order_details.types_of_duration_id");
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('order_details.types_of_box_room_id', 2);
        $query->where(function ($q) use ($args) {
                $q->where('users.first_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('users.last_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('order_details.id_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('space_smalls.name', 'like', '%'.$args['searchValue'].'%');
            });
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data->toArray();

    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(OrderDetail $order, $data)
    {
        return $order->update($data);
    }

    public function delete(OrderDetail $order)
    {
        return $order->delete();
    }
}
