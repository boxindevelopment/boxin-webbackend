<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Repositories\DashboardRepository;
use Carbon;

class DashboardController extends Controller
{
    protected $data;

    public function __construct(DashboardRepository $data)
    {
        $this->data = $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user      = $request->user();
        $city      = $this->data->countCity();
        $area      = $this->data->countArea();
        $space     = $this->data->countSpace();
        $available_space = $this->data->countSpaceAvailable();
        $box       = $this->data->countBox();
        $shelves   = $this->data->countShelves();
        $available_box      = $this->data->countBoxAvailable();
        $totalSales         = $this->data->totalSales();
        $totalSalesMonth    = $this->data->totalSalesMonth();
        $me                 = Auth::id();
        return view('dashboard', compact('city', 'space', 'box', 'area', 'me', 'available_space', 'available_box', 'shelves', 'totalSales', 'totalSalesMonth'));
    }

    public function graphicOrder()
    {
        $chartData = $this->data->getGraphicOrder();
        $chartDatas = $chartData->get()->toArray();
        
        $chartDataByDay = array();
        foreach($chartDatas as $data) {
             $chartDataByDay[date("Y-m", mktime(0, 0, 0, $data['Month'], 1,$data['Year']))] = $data['TotalAmount'];
        }

        $date = new Carbon\Carbon;
        for($i = 0; $i < 12; $i++) {
            $dateString = $date->format('Y-m');
            if(!isset($chartDataByDay[ $dateString ])) {
                $chartDataByDay[ $dateString ] = 0;
            }
            $date->subMonth();
        }

        ksort($chartDataByDay);
        echo (json_encode($chartDataByDay));
    }
    
}
