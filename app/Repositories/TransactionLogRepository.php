<?php

namespace App\Repositories;

use App\Model\AdminArea;
use App\Model\TransactionLog;
use App\Repositories\Contracts\TransactionLogRepository as TransactionLogRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon;

class TransactionLogRepository implements TransactionLogRepositoryInterface
{
    protected $model;

    public function __construct(TransactionLog $model)
    {
        $this->model        = $model;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getBoxCount($args = [])
    {
        
        $fromDate = $newDate = date("Y-m-d", strtotime(str_replace('/', '-', $args['from_date'])));
        $toDate = $newDate = date("Y-m-d", strtotime(str_replace('/', '-', $args['to_date'])));
        $query = $this->model->query();
        $query->join("order_details", "order_details.id", "transaction_logs.order_detail_id");
        $query->join("boxes", "boxes.id", "order_details.room_or_box_id");
        $query->join("orders", "orders.id", "order_details.order_id");
        $query->join("users", "users.id", "orders.user_id");
        $query->where(function ($q) use ($args) {
                $q->where('users.first_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('users.last_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('order_details.id_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('boxes.name', 'like', '%'.$args['searchValue'].'%');
            });
        $query->where('transaction_logs.types_of_pickup_id', 1);
        $query->where('transaction_logs.types_of_box_space_small_id', 1);
        $query->where(function ($q) use ($args) {
            $fromDate = $newDate = date("Y-m-d", strtotime(str_replace('/', '-', $args['from_date'])));
            $toDate = $newDate = date("Y-m-d", strtotime(str_replace('/', '-', $args['to_date'])));
            $q->orWhereRaw("(transaction_type ='start storing' AND transaction_logs.order_id IN (SELECT order_id FROM pickup_orders WHERE date >= '".$fromDate."' AND date <= '".$toDate."'))");
            $q->orWhereRaw("(transaction_type ='take' AND transaction_logs.order_id IN (SELECT id FROM order_takes WHERE date >= '".$fromDate."' AND date <= '".$toDate."'))");
            $q->orWhereRaw("(transaction_type ='back warehouse' AND transaction_logs.order_id IN (SELECT id FROM order_back_warehouses WHERE date >= '".$fromDate."' AND date <= '".$toDate."'))");
            $q->orWhereRaw("(transaction_type ='terminate' AND transaction_logs.order_id IN (SELECT id FROM return_boxes WHERE date >= '".$fromDate."' AND date <= '".$toDate."'))");
        });

        return $query->count();
    }

    public function getBoxData($args = [])
    {

        $query = $this->model->query();
        $query->select('transaction_logs.*', 'boxes.name as box_name', 'users.first_name', 'users.last_name', 'order_details.id_name', 'order_details.types_of_size_id', 'order_details.name');
        $query->join("order_details", "order_details.id", "transaction_logs.order_detail_id");
        $query->join("boxes", "boxes.id", "order_details.room_or_box_id");
        $query->join("orders", "orders.id", "order_details.order_id");
        $query->join("users", "users.id", "orders.user_id");
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('transaction_logs.types_of_pickup_id', 1);
        $query->where('transaction_logs.types_of_box_space_small_id', 1);
        $query->where(function ($q) use ($args) {
                $q->where('users.first_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('users.last_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('order_details.id_name', 'like', '%'.$args['searchValue'].'%')
                      ->orWhere('boxes.name', 'like', '%'.$args['searchValue'].'%');
            });
        $query->where(function ($q) use ($args) {
            $fromDate = $newDate = date("Y-m-d", strtotime(str_replace('/', '-', $args['from_date'])));
            $toDate = $newDate = date("Y-m-d", strtotime(str_replace('/', '-', $args['to_date'])));
            $q->orWhereRaw("(transaction_type ='start storing' AND transaction_logs.order_id IN (SELECT order_id FROM pickup_orders WHERE date >= '".$fromDate."' AND date <= '".$toDate."'))");
            $q->orWhereRaw("(transaction_type ='take' AND transaction_logs.order_id IN (SELECT id FROM order_takes WHERE date >= '".$fromDate."' AND date <= '".$toDate."'))");
            $q->orWhereRaw("(transaction_type ='back warehouse' AND transaction_logs.order_id IN (SELECT id FROM order_back_warehouses WHERE date >= '".$fromDate."' AND date <= '".$toDate."'))");
            $q->orWhereRaw("(transaction_type ='terminate' AND transaction_logs.order_id IN (SELECT id FROM return_boxes WHERE date >= '".$fromDate."' AND date <= '".$toDate."'))");
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

    public function update(TransactionLog $log, $data)
    {
        return $log->update($data);
    }

    public function delete(TransactionLog $log)
    {
        return $log->delete();
    }
}
