<?php

namespace App\Repositories;
use App\Model\City;
use App\Model\Box;
use App\Model\Space;
use App\Model\Area;
use App\Model\Shelves;
use App\Repositories\Contracts\DashboardRepository as DashboardRepositoryInterface;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Model\AdminArea;

class DashboardRepository implements DashboardRepositoryInterface
{
    protected $city;
    protected $area;
    protected $space;
    protected $shelves;
    protected $box;
    
    public function __construct(City $city, Area $area, Space $space, Shelves $shelves, Box $box)
    {        
        $this->city      = $city;
        $this->area      = $area;
        $this->space     = $space;
        $this->shelves   = $shelves;
        $this->box       = $box;
    }

    public function countCity()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->city->query();
        $data = $data->where('cities.deleted_at', NULL);
        $data = $data->count();
        return $data;
    }
        
    public function countArea()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->area->query();
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('deleted_at', NULL);
        $data = $data->count();
        return $data;
    }

    public function countSpace()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->space->query();
        $data = $data->leftJoin('areas', 'areas.id', '=', 'spaces.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('spaces.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->count();
        return $data;
    }

    public function countBox()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->box->query();
        $data = $data->leftJoin('shelves', 'shelves.id', '=', 'boxes.shelves_id');
        $data = $data->leftJoin('spaces', 'spaces.id', '=', 'shelves.space_id');        
        $data = $data->leftJoin('areas', 'areas.id', '=', 'spaces.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('boxes.deleted_at', NULL); 
        $data = $data->where('areas.deleted_at', NULL);     
        $data = $data->count();
        return $data;
    }
   

}