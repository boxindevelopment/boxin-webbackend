<?php

namespace App\Repositories;

use App\Model\Payment;
use App\Model\ExtendOrderPayment;
use App\Model\AdminArea;
use App\Repositories\Contracts\ExtendPaymentRepository as ExtendPaymentRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class ExtendPaymentRepository implements ExtendPaymentRepositoryInterface
{
    protected $model;

    public function __construct(ExtendOrderPayment $model)
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
        $data = $data->select('extend_order_payments.id', 'extend_order_payments.order_detail_id', 'extend_order_payments.extend_id', 'extend_order_payments.image_transfer', 'extend_order_payments.status_id', 'extend_order_payments.id_name', 'extend_order_payments.created_at', 'users.first_name',  'users.last_name');
        $data = $data->leftJoin('order_details','order_details.id','=','extend_order_payments.order_detail_id');
        $data = $data->leftJoin('users','users.id','=','extend_order_payments.user_id');
        $data = $data->leftJoin('orders','orders.id','=','order_details.order_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('orders.area_id', $admin->area_id);
        }
        $data = $data->orderBy('extend_order_payments.status_id', 'DESC');
        $data = $data->get();
        return $data;
    }

    public function getById($id)
    {
        $data = $this->model->query();
        $data = $data->select('extend_order_payments.*', 'users.first_name',  'users.last_name');
        $data = $data->leftJoin('order_details','order_details.id','=','extend_order_payments.order_detail_id');
        $data = $data->leftJoin('orders','orders.id','=','order_details.order_id');
        $data = $data->leftJoin('users','users.id','=','extend_order_payments.user_id');
        $data = $data->where('extend_order_payments.id', $id);
        $data = $data->get();
        return $data;
    }

    public function getCount($args = [])
    {
        $query = $this->model->query();
        $query->leftJoin('order_details','order_details.id','=','extend_order_payments.order_detail_id');
        $query->leftJoin('orders','orders.id','=','order_details.order_id');
        $query->leftJoin('users','users.id','=','extend_order_payments.user_id');
        $query->leftJoin('status','status.id','=','extend_order_payments.status_id');
        $query->where('extend_order_payments.id_name', 'like', '%'.$args['searchValue'].'%');
        return $query->count();
    }

    public function getData($args = [])
    {

        $query = $this->model->query();
        $query->select('extend_order_payments.*', 'users.first_name',  'users.last_name', 'status.name as status_name');
        $query->leftJoin('order_details','order_details.id','=','extend_order_payments.order_detail_id');
        $query->leftJoin('orders','orders.id','=','order_details.order_id');
        $query->leftJoin('users','users.id','=','extend_order_payments.user_id');
        $query->leftJoin('status','status.id','=','extend_order_payments.status_id');
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('extend_order_payments.id_name', 'like', '%'.$args['searchValue'].'%');
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data->toArray();

    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(ExtendOrderPayment $pay, $data)
    {
        return $pay->update($data);
    }

    public function delete(ExtendOrderPayment $pay)
    {
        return $pay->delete();
    }
}
