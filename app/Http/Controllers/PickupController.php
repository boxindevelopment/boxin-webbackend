<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PickupOrder;
use App\Model\Order;
use App\Model\OrderDetail;
use DB;
use Carbon\Carbon;
use App\Repositories\PickupOrderRepository;
use Requests;

class PickupController extends Controller
{
    protected $repository;

	private $url;
	CONST DEV_URL = 'https://boxin-dev-notification.azurewebsites.net/';
	CONST LOC_URL = 'http://localhost:5252/';
	CONST PROD_URL = 'https://boxin-prod-notification.azurewebsites.net/';

    public function __construct(PickupOrderRepository $repository)
    {
		$this->url        = (env('DB_DATABASE') == 'coredatabase') ? self::DEV_URL : self::PROD_URL;
        $this->repository = $repository;
    }

    public function index()
    {
      $pickup = $this->repository->all();
      return view('pickup.index', compact('pickup'));
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

    public function edit($id)
    {
      $pickup     = PickupOrder::select('pickup_orders.*')->where('id',$id)->get();
      return view('pickup.edit', compact('pickup', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status_id'  => 'required',
        ]);

        $order_id               = $request->order_id;
        $status                 = $request->status_id;

        $order                  = Order::find($order_id);
        $order->status_id       = $status == '12' ? '4' : $status;
        $order->save();

        $order_details          = OrderDetail::where('order_id', $order_id)->get();
        $count                  = count($order_details);
        for ($i = 0; $i < $count; $i++) {
            $order_detail            = OrderDetail::find($order_details[$i]->id);
            $order_detail->status_id =  $status == '12' ? '4' : $status;
            $order_detail->start_date= Carbon::now();
            if($order_detail->status_id == '4' || $order_detail->status_id == 4) {
                // daily
                if ($order_detail->types_of_duration_id == 1 || $order_detail->types_of_duration_id == '1') {
                    $order_detail->end_date     = date('Y-m-d', strtotime('+'.$order_detail->duration.' days', strtotime($order_detail->start_date)));

                }
                // weekly
                else if ($order_detail->types_of_duration_id == 2 || $order_detail->types_of_duration_id == '2') {
                    $end_date                   = $order_detail->duration*7;
                    $order_detail->end_date     = date('Y-m-d', strtotime('+'.$end_date.' days', strtotime($order_detail->start_date)));
                }
                // monthly
                else if ($order_detail->types_of_duration_id == 3 || $order_detail->types_of_duration_id == '3') {
                    $order_detail->end_date     = date('Y-m-d', strtotime('+'.$order_detail->duration.' month', strtotime($order_detail->start_date)));
                }
                // 6month
                else if ($order_detail->types_of_duration_id == 7 || $order_detail->types_of_duration_id == '7') {
                    $end_date                   = $order_detail->duration*6;
                    $order_detail->end_date     = date('Y-m-d', strtotime('+'.$end_date.' month', strtotime($order_detail->start_date)));
                }
                // annual
                else if ($order_detail->types_of_duration_id == 8 || $order_detail->types_of_duration_id == '8') {
                    $end_date                   = $order_detail->duration*12;
                    $order_detail->end_date     = date('Y-m-d', strtotime('+'.$end_date.' month', strtotime($order_detail->start_date)));
                }
            }
            $order_detail->save();
        }

        $pickup                 = PickupOrder::find($id);
        $pickup->status_id      = $status;
        $pickup->driver_name    = $request->driver_name;
        $pickup->driver_phone   = $request->driver_phone;
        $pickup->save();

        if($pickup){
            $params['status_id'] =  $status;
            if($status == 2){
                //Notif message "Your items is on the way back to you"
        		$response = Requests::post($this->url . 'api/delivery/stored/' . $order->user_id, [], $params, []);
            } else if($status == 12){
                //Notif message "Congratulation! Your items has been stored"
        		$response = Requests::post($this->url . 'api/item-save/' . $order->user_id, [], $params, []);
            }
            return redirect()->route('pickup.index')->with('success', 'Edit Data Pickup Order success.');
        } else {
            return redirect()->route('pickup.index')->with('error', 'Edit Data Pickup Order failed.');
        }
    }

    public function destroy($id)
    {

    }
}
