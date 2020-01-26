<?php

namespace App\Repositories;

use App\Model\SpaceSmall;
use App\Model\AdminArea;
use App\Repositories\Contracts\SpaceSmallRepository as SpaceSmallRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;

class SpaceSmallRepository implements SpaceSmallRepositoryInterface
{
    protected $model;

    public function __construct(SpaceSmall $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getById($id)
    {
        return $this->model->where('deleted_at', NULL)->where('id', $id)->get();
    }

    public function getDatas($args = [])
    {
        $query = $this->model->query();
        $query->select('space_smalls.*');
        $query->leftJoin('shelves', 'shelves.id', '=', 'space_smalls.shelves_id');

        if(isset($args['orderColumns']) && isset($args['orderDir'])){
            $query->orderBy($args['orderColumns'], $args['orderDir']);
        }
        if(isset($args['status_id'])){
            $query->where('space_smalls.status_id', $args['status_id']);
        }
        if(isset($args['area_id'])){
            $query->where('shelves.area_id', $args['area_id']);
        }
        if(isset($args['types_of_size_id'])){
            $query->where('space_smalls.types_of_size_id', $args['types_of_size_id']);
        }
        if(isset($args['start'])){
            $query->skip($args['start']);
        }
        if(isset($args['length'])){
            $query->take($args['length']);
        }
        $query->where('space_smalls.deleted_at', NULL);
        $spaceSmall = $query->first();

        return $spaceSmall;

    }

    public function all()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $query = $this->model->query();
        $query->select('space_smalls.*');
        if(Auth::user()->roles_id == 2){
            $query->leftJoin('shelves', 'shelves.id', '=', 'space_smalls.shelves_id');
            $data = $data->where('shelves.area_id', $admin->area_id);
            $query->where('shelves.deleted_at', NULL);
        }
        $query->where('space_smalls.deleted_at', NULL);
        $query->orderBy('space_smalls.updated_at', 'DESC')->orderBy('space_smalls.id','DESC');
        $data = $query->get();
        return $data;
    }

    public function getCount($args = [])
    {
        return $this->model
                    ->join("types_of_size", "types_of_size.id", "space_smalls.types_of_size_id")
                    ->join("shelves", "shelves.id", "space_smalls.shelves_id")
                    ->join("status", "status.id", "space_smalls.status_id")
                    ->where('space_smalls.name', 'like', $args['searchValue'].'%')
                    ->count();
    }
    public function getData($args = [])
    {

        $warehouse = $this->model->select("space_smalls.*", "types_of_size.name as type_size_name",
                                     "types_of_size.size", "shelves.name as shelves_name",
                                     "status.name as status_name")
                                ->join("types_of_size", "types_of_size.id", "space_smalls.types_of_size_id")
                                ->join("shelves", "shelves.id", "space_smalls.shelves_id")
                                ->join("status", "status.id", "space_smalls.status_id")
                                ->orderBy($args['orderColumns'], $args['orderDir'])
                                ->where('space_smalls.name', 'like', '%'.$args['searchValue'].'%')
                                ->skip($args['start'])
                                ->take($args['length'])
                                ->get();

        return $warehouse->toArray();

    }

    public function getSelectByArea($area_id)
    {

        $query = $this->model->query();
                $query->whereRaw("shelves_id IN (Select id WHERE area_id = ".$area_id." )");
                $query->where('deleted_at', NULL);
                $query->orderBy('name')->get();

        return $space_smalls;

    }

    public function getDataSelectByShelves($shelves_id)
    {

        $space_smalls = $this->model->select()->where('shelves_id', $shelves_id)->where('deleted_at', NULL)->orderBy('name')->get();

        return $space_smalls;

    }

    public function getSelectAll($args = [])
    {

        $warehouse = $this->model->select()->where('deleted_at', NULL)->orderBy('name')->get();

        return $warehouse;

    }

    public function getEdit($id)
    {
        $data = $this->model->where('id', $id)->first();
        return $data;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(SpaceSmall $SpaceSmall, $data)
    {
        return $SpaceSmall->update($data);
    }

    public function delete(SpaceSmall $SpaceSmall)
    {
        return $SpaceSmall->delete();
    }
}
