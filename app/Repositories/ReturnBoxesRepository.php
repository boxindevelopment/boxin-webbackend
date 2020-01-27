<?php

namespace App\Repositories;

use App\Model\ReturnBoxes;
use App\Model\AdminArea;
use App\Repositories\Contracts\ReturnBoxesRepository as ReturnBoxesRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ReturnBoxesRepository;

class ReturnBoxesRepository implements ReturnBoxesRepositoryInterface
{
    protected $model;

    public function __construct(ReturnBoxes $model)
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
        $order = $order->select('return_boxes.id', 'return_boxes.order_detail_id', 'return_boxes.types_of_pickup_id', 'return_boxes.status_id', 'return_boxes.created_at', 'return_boxes.date', 'return_boxes.time_pickup');
        $order = $order->leftJoin('order_details','order_details.id','=','return_boxes.order_detail_id');
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
        $query->leftJoin('order_details','order_details.id','=','change_box_payments.order_detail_id');
        $query->leftJoin('users','users.id','=','change_box_payments.user_id');
        $query->leftJoin('status','status.id','=','change_box_payments.status_id');
        if(Auth::user()->roles_id == 2){
            $query->leftJoin('orders','orders.id','=','order_details.order_id');
            $query->where('orders.area_id', $admin->area_id);
        }
        $query->where('return_boxes.id_name', 'like', '%'.$args['searchValue'].'%');
        return $query->count();
    }

    public function getData($args = [])
    {

        $query = $this->model->query();
        $query->select('return_boxes.*', 'users.first_name',  'users.last_name', 'status.name as status_name');
        $query->leftJoin('order_details','order_details.id','=','return_boxes.order_detail_id');
        $query->leftJoin('orders','orders.id','=','order_details.order_id');
        $query->leftJoin('status','status.id','=','change_box_payments.status_id');
        if(Auth::user()->roles_id == 2){
            $query->where('orders.area_id', $admin->area_id);
        }
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('return_boxes.id_name', 'like', '%'.$args['searchValue'].'%');
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data->toArray();

    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(ReturnBoxes $box, $data)
    {
        return $box->update($data);
    }

    public function delete(ReturnBoxes $box)
    {
        return $box->delete();
    }
}
