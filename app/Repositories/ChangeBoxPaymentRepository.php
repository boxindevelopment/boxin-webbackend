<?php

namespace App\Repositories;

use App\Model\ChangeBoxPayment;
use App\Model\AdminArea;
use App\Repositories\Contracts\ChangeBoxPaymentRepository as ChangeBoxPaymentRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class ChangeBoxPaymentRepository implements ChangeBoxPaymentRepositoryInterface
{
    protected $model;

    public function __construct(ChangeBoxPayment $model)
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
        $data = $data->select('change_box_payments.id', 'change_box_payments.image_transfer', 'change_box_payments.order_detail_id', 'change_box_payments.status_id', 'change_box_payments.id_name', 'change_box_payments.created_at', 'users.first_name',  'users.last_name');
        $data = $data->leftJoin('order_details','order_details.id','=','change_box_payments.order_detail_id');
        $data = $data->leftJoin('users','users.id','=','change_box_payments.user_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('orders','orders.id','=','order_details.order_id');
            $data = $data->where('orders.area_id', $admin->area_id);
        }
        $data = $data->orderBy('change_box_payments.status_id', 'DESC')->orderBy('id', 'ASC');
        $data = $data->get();
        return $data;
    }

    public function getById($id)
    {
        $data = $this->model->query();
        $data = $data->select('change_box_payments.*', 'users.first_name',  'users.last_name');
        $data = $data->leftJoin('order_details','order_details.id','=','change_box_payments.order_detail_id');
        $data = $data->leftJoin('users','users.id','=','change_box_payments.user_id');
        $data = $data->where('change_box_payments.id', $id);
        $data = $data->get();
        return $data;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(ChangeBoxPayment $pay, $data)
    {
        return $pay->update($data);
    }

    public function delete(ChangeBoxPayment $pay)
    {
        return $pay->delete();
    }
}
