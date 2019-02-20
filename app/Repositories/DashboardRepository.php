<?php

namespace App\Repositories;
use App\Model\City;
use App\Model\Box;
use App\Model\Space;
use App\Model\Area;
use App\Model\Shelves;
use App\Model\OrderDetail;
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
    protected $order;

    public function __construct(City $city, Area $area, Space $space, Shelves $shelves, Box $box, OrderDetail $order_detail)
    {
        $this->city      = $city;
        $this->area      = $area;
        $this->space     = $space;
        $this->shelves   = $shelves;
        $this->box       = $box;
        $this->order_detail     = $order_detail;
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

    public function countSpaceAvailable()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->space->query();
        $data = $data->leftJoin('areas', 'areas.id', '=', 'spaces.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('spaces.status_id', 10);
        $data = $data->where('spaces.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->count();
        return $data;
    }

    public function countShelves()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->shelves->query();
        $data = $data->leftJoin('areas', 'areas.id', '=', 'shelves.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('shelves.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->count();
        return $data;
    }

    public function countBox()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->box->query();
        $data = $data->leftJoin('shelves', 'shelves.id', '=', 'boxes.shelves_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'shelves.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('boxes.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->count();
        return $data;
    }

    public function countBoxAvailable()
    {
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->box->query();
        $data = $data->leftJoin('shelves', 'shelves.id', '=', 'boxes.shelves_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'shelves.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('boxes.deleted_at', NULL);
        $data = $data->where('areas.deleted_at', NULL);
        $data = $data->where('boxes.status_id', 10);
        $data = $data->count();
        return $data;
    }

    public function totalSales(){
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->order_detail->query();
        $data = $data->select(DB::raw('SUM(order_details.amount) as total'));
        $data = $data->leftJoin('orders', 'orders.id', '=', 'order_details.order_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'orders.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('orders.deleted_at', NULL);
        $data = $data->first();
        return $data;
    }

    public function totalSalesMonth(){
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->order_detail->query();
        $data = $data->select(DB::raw('SUM(order_details.amount) as total'));
        $data = $data->leftJoin('orders', 'orders.id', '=', 'order_details.order_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'orders.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->where('orders.deleted_at', NULL);
        $data = $data->whereRaw("MONTH(orders.created_at) = " . date('m'));
        $data = $data->first();
        return $data;
    }

    public function getGraphicOrder(){
        $admin = AdminArea::where('user_id', Auth::user()->id)->first();
        $data = $this->order_detail->query();
        $data = $data->select(DB::raw('DATEPART(Year, order_details.created_at) Year'), DB::raw('DATEPART(Month, order_details.created_at) Month'), DB::raw('SUM(amount) [TotalAmount]'));
        $data = $data->leftJoin('orders', 'orders.id', '=', 'order_details.order_id');
        $data = $data->leftJoin('areas', 'areas.id', '=', 'orders.area_id');
        if(Auth::user()->roles_id == 2){
            $data = $data->where('areas.id', $admin->area_id);
        }
        $data = $data->whereRaw("YEAR(order_details.created_at) = " . date('Y'));
        $data = $data->groupBy(DB::raw("DATEPART(Year, order_details.created_at)"));
        $data = $data->groupBy(DB::raw("DATEPART(Month, order_details.created_at)"));
        $data = $data->orderBy('Month', 'DESC');
        return $data;
    }


}
