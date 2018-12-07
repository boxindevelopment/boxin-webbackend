<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrderDetailRepository;
use Carbon;

class OrderDetailController extends Controller
{
    protected $repository;

    public function __construct(OrderDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $order   = $this->repository->all();
      return view('storage.index', compact('order'));
    }

    public function create()
    {
      abort('404');
    }

    public function store(Request $request)
    {
      abort('404');   
    }

    public function show($id)
    {
      abort('404');
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    
    }

    public function orderDetailBox($id)
    {
        $detail             = $this->repository->getOrderDetail($id);
        $detail_order_box   = $this->repository->getDetailBox($id);
        return view('storage.box-detail', compact('detail_order_box', 'id', 'detail'));
    }

    public function graphicOrder()
    {
        $chartData = $this->repository->getGraphicOrder();
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
