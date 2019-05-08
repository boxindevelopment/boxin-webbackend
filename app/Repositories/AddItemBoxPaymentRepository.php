<?php

namespace App\Repositories;

use App\Model\AddItemBoxPayment;
use App\Model\AdminArea;
use App\Repositories\Contracts\AddItemBoxPaymentRepository as AddItemBoxPaymentRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class AddItemBoxPaymentRepository implements AddItemBoxPaymentRepositoryInterface
{
    protected $model;

    public function __construct(AddItemBoxPayment $model)
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
        $data = $data->select('add_item_box_payments.id', 
                              'add_item_box_payments.image_transfer', 
                              'add_item_box_payments.order_detail_id', 
                              'add_item_box_payments.status_id', 
                              'add_item_box_payments.id_name', 
                              'add_item_box_payments.created_at', 
                              'users.first_name',  'users.last_name');
        $data = $data->leftJoin('order_details','order_details.id','=','add_item_box_payments.order_detail_id');
        $data = $data->leftJoin('users','users.id','=','add_item_box_payments.user_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('orders','orders.id','=','order_details.order_id');
            $data = $data->where('orders.area_id', $admin->area_id);
        }
        $data = $data->orderBy('add_item_box_payments.status_id', 'DESC')->orderBy('id', 'ASC');
        $data = $data->get();
        return $data;
    }

    public function getById($id)
    {
        $data = $this->model->query();
        $data = $data->select('add_item_box_payments.*', 'users.first_name',  'users.last_name');
        $data = $data->leftJoin('order_details','order_details.id','=','add_item_box_payments.order_detail_id');
        $data = $data->leftJoin('users','users.id','=','add_item_box_payments.user_id');
        $data = $data->where('add_item_box_payments.id', $id);
        $data = $data->get();
        return $data;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(AddItemBoxPayment $pay, $data)
    {
        return $pay->update($data);
    }

    public function delete(AddItemBoxPayment $pay)
    {
        return $pay->delete();
    }
}
