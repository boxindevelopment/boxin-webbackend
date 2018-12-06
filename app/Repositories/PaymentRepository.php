<?php

namespace App\Repositories;

use App\Model\Payment;
use App\Model\AdminArea;
use App\Repositories\Contracts\PaymentRepository as PaymentRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class PaymentRepository implements PaymentRepositoryInterface
{
    protected $model;

    public function __construct(Payment $model)
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
        $data = $data->select('payments.id', 'payments.order_id', 'payments.status_id', 'payments.id_name', 'payments.created_at', 'users.first_name',  'users.last_name');
        $data = $data->leftJoin('orders','orders.id','=','payments.order_id');      
        $data = $data->leftJoin('users','users.id','=','payments.user_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('orders.area_id', $admin->area_id);
        }
        $data = $data->orderBy('payments.status_id', 'DESC')->orderBy('id', 'ASC');
        $data = $data->get();
        return $data;
    }

    public function getById($id)
    {
        $data = $this->model->query();
        $data = $data->select('payments.*', 'users.first_name',  'users.last_name');
        $data = $data->leftJoin('orders','orders.id','=','payments.order_id');      
        $data = $data->leftJoin('users','users.id','=','payments.user_id');
        $data = $data->where('payments.id', $id);
        $data = $data->get();
        return $data;
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
    
    public function update(Payment $pay, $data)
    {
        return $pay->update($data);
    }

    public function delete(Payment $pay)
    {
        return $pay->delete();
    }
}