<?php

namespace App\Repositories;

use App\Model\Notification;
use App\Model\User;
use App\Repositories\Contracts\NotificationRepository as NotificationRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\NotificationRepository;

class NotificationRepository implements NotificationRepositoryInterface
{
    protected $model;

    public function __construct(Notification $model)
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

    public function getCountUnRead()
    {
        $query = $this->model->query();
        $query->where('notifiable_type', 'admin');
        $query->whereNull('read_at');
        return $query->count();
    }

    public function getCount($args = [])
    {
        $query = $this->model->query();
        $query->leftJoin('users','users.id','=','notifications.send_user');
        $query->where('notifications.title', 'like', '%'.$args['searchValue'].'%');
        $query->where('notifications.notifiable_type', 'admin');
        return $query->count();
    }

    public function getData($args = [])
    {

        $query = $this->model->query();
        $query->select('notifications.*', 'users.first_name',  'users.last_name');
        $query->leftJoin('users','users.id','=','notifications.send_user');
        $query->orderBy($args['orderColumns'], $args['orderDir']);
        $query->where('notifications.title', 'like', '%'.$args['searchValue'].'%');
        $query->where('notifications.notifiable_type', 'admin');
        $query->skip($args['start']);
        $query->take($args['length']);
        $data = $query->get();

        return $data;

    }
    public function getDataLimit($limit)
    {

        $query = $this->model->query();
        $query->select('notifications.*', 'users.first_name',  'users.last_name', DB::raw("format(notifications.created_at, 'dd/MM/yyyy HH:mm') as datetime_notif"));
        $query->leftJoin('users','users.id','=','notifications.send_user');
        $query->where('notifications.notifiable_type', 'admin');
        $query->orderBy('notifications.id', 'desc');
        $query->limit($limit);
        $data = $query->get();

        return $data;

    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Notification $notification, $data)
    {
        return $notification->update($data);
    }

    public function delete(Notification $notification)
    {
        return $notification->delete();
    }
}
