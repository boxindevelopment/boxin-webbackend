<?php

namespace App\Repositories;

use App\Model\DeliveryFee;
use App\Repositories\Contracts\DeliveryFeeRepository as PricDeliveryFeeRepositoryInterface;
use DB;
use App\Model\AdminArea;
use Illuminate\Support\Facades\Auth;

class DeliveryFeeRepository implements DeliveryFeeRepositoryInterface
{
    protected $model;

    public function __construct(DeliveryFee $model)
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
        $data = $this->model->query();
        $data = $data->with('area');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('delivery_fee.area_id', $admin->area_id);
        }
        $data = $data->orderBy('id');
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
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(Price $price, $data)
    {
        return $price->update($data);
    }

    public function delete(Price $price)
    {
        return $price->delete();
    }
}