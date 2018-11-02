<?php

namespace App\Repositories;
use App\Model\Warehouse;
use App\Model\Box;
use App\Model\Room;
use App\Model\Space;
use App\Model\Area;
use App\Repositories\Contracts\DashboardRepository as DashboardRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Model\AdminCity;

class DashboardRepository implements DashboardRepositoryInterface
{
   
    protected $area;
    protected $warehouse;
    protected $space;
    protected $box;
    protected $room;
    
    public function __construct(Warehouse $warehouse, Area $area, Box $box, Space $space, Room $room)
    {
        $this->area      = $area;
        $this->warehouse = $warehouse;
        $this->space     = $space;
        $this->box       = $box;
        $this->room      = $room;
    }
        
    public function countArea()
    {
        $admin = AdminCity::where('user_id', Auth::user()->id)->first();
        $data = $this->area->query();
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->count();
        return $data;
    }

    public function countWarehouse()
    {
        $admin = AdminCity::where('user_id', Auth::user()->id)->first();
        $data = $this->warehouse->query();
        $data = $data->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('warehouses.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->count();
        return $data;
    }

    public function countBox()
    {
        $admin = AdminCity::where('user_id', Auth::user()->id)->first();
        $data = $this->box->query();
        $data = $data->leftJoin('spaces', 'spaces.id', '=', 'boxes.space_id');
        $data = $data->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('boxes.deleted_at', NULL); 
        $data = $data->where('areas.deleted_at', NULL);     
        $data = $data->count();
        return $data;
    }

    public function countRoom()
    {
        $admin = AdminCity::where('user_id', Auth::user()->id)->first();
        $data = $this->room->query();
        $data = $data->leftJoin('spaces', 'spaces.id', '=', 'rooms.space_id');
        $data = $data->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('rooms.deleted_at', NULL); 
        $data = $data->where('areas.deleted_at', NULL);     
        $data = $data->count();
        return $data;
    }

    public function countSpace()
    {
        $admin = AdminCity::where('user_id', Auth::user()->id)->first();
        $data = $this->space->query();
        $data = $data->leftJoin('warehouses', 'warehouses.id', '=', 'spaces.warehouse_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'warehouses.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->leftJoin('cities', 'cities.id', '=', 'areas.city_id');
            $data = $data->where('areas.city_id', $admin->city_id);
        }
        $data = $data->where('spaces.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->count();
        return $data;
    }

}