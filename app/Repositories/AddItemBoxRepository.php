<?php

namespace App\Repositories;

use App\Model\AddItemBox;
use App\Model\AdminArea;
use App\Repositories\Contracts\AddItemBoxRepository as AddItemBoxRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AddItemBoxRepository;

class AddItemBoxRepository implements AddItemBoxRepositoryInterface
{
    protected $model;

    public function __construct(AddItemBox $model)
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
        $order = $order->select('add_item_boxes.id',
                                'add_item_boxes.order_detail_id',
                                'add_item_boxes.types_of_pickup_id',
                                'add_item_boxes.status_id',
                                'add_item_boxes.created_at',
                                'add_item_boxes.date',
                                'add_item_boxes.time_pickup');
        $order = $order->leftJoin('order_details','order_details.id','=','add_item_boxes.order_detail_id');
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
        $query->leftJoin('order_details','order_details.id','=','add_item_boxes.order_detail_id');
        $query->leftJoin('orders','orders.id','=','order_details.order_id');
        $query->leftJoin('users','users.id','=','orders.user_id');
        $query->leftJoin('status','status.id','=','orders.status_id');
        if(Auth::user()->roles_id == 2){
            $query->where('orders.area_id', $admin->area_id);
        }
        $query->where('users.first_name', 'like', '%'.$args['searchValue'].'%');

        return $query->count();
    }

    public function getData($args = [])
    {

        $query = $this->model->query();
        $query->select('add_item_boxes.*', 'users.first_name', 'users.last_name', 'status.name as status_name');
        $query->leftJoin('order_details','order_details.id','=','add_item_boxes.order_detail_id');
        $query->leftJoin('orders','orders.id','=','order_details.order_id');
        $query->leftJoin('users','users.id','=','orders.user_id');
        $query->leftJoin('status','status.id','=','add_item_boxes.status_id');
        if(Auth::user()->roles_id == 2){
            $query->where('orders.area_id', $admin->area_id);
        }
        $query->where('users.first_name', 'like', '%'.$args['searchValue'].'%');
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data;

    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(AddItemBox $box, $data)
    {
        return $box->update($data);
    }

    public function delete(AddItemBox $box)
    {
        return $box->delete();
    }
}
