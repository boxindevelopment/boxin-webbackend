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

    public function getOrderDetail($id)
    {
        $data = $this->model->query();
        $data = $data->select('order_details.*', 'users.*', 'pickup_orders.*');
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
        $data = $data->where('order_detail_id', $id);
        $data = $data->orderBy('id', 'ASC');
        $data = $data->get();
        return $data;
    }

    public function getGraphicOrder(){
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->model->query();     
        $data = $data->select(DB::raw('DATEPART(Year, order_details.created_at) Year'), DB::raw('DATEPART(Month, order_details.created_at) Month'), DB::raw('SUM(amount) [TotalAmount]'));   
        $data = $data->leftJoin('orders', 'orders.id', '=', 'order_details.order_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'orders.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->whereBetween("order_details.created_at", [Carbon\Carbon::now()->subMonth(12), Carbon\Carbon::now()]);
        // $data = $data->whereRaw("YEAR(order_details.created_at) = " . date('Y'));
        $data = $data->groupBy(DB::raw("DATEPART(Year, order_details.created_at)"), DB::raw("DATEPART(Month, order_details.created_at)"));
        $data = $data->orderBy('Month');
        // $data = $data->get();
        return $data;
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