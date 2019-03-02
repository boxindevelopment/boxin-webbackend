<?php

namespace App\Repositories;

use App\Model\ChangeBox;
use App\Model\AdminArea;
use App\Repositories\Contracts\ChangeBoxRepository as ChangeBoxRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ChangeBoxRepository;

class ChangeBoxRepository implements ChangeBoxRepositoryInterface
{
    protected $model;

    public function __construct(ChangeBox $model)
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
        // $order = $order->select('change_boxes.id', 'change_boxes.order_detail_box_id', 'change_boxes.types_of_pickup_id', 'change_boxes.status_id', 'change_boxes.created_at', 'change_boxes.date', 'change_boxes.time_pickup', 'change_boxes.order_detail_id');
        $order = $order->select('change_boxes.*');
        $order = $order->leftJoin('order_detail_boxes','order_detail_boxes.id','=','change_boxes.order_detail_box_id');
        $order = $order->leftJoin('order_details','order_details.id','=','order_detail_boxes.order_detail_id');
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
    
    public function update(ChangeBox $box, $data)
    {
        return $box->update($data);
    }

    public function delete(ChangeBox $box)
    {
        return $box->delete();
    }
}