<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\Order;
use App\Model\Box;
use App\Model\SpaceSmall;
use App\Model\OrderDetail;
use App\Model\PickupOrder;
use App\Model\UserDevice;
use App\Repositories\PaymentRepository;
use App\Repositories\ExtendPaymentRepository;
use App\Model\ExtendOrderDetail;
use App\Model\ExtendOrderPayment;
use App\Model\HistoryOrderDetailBox;
use Requests;
use Exception;
use DB;

class PaymentController extends Controller
{

    protected $repository;
    protected $repository2;

	private $url;
	CONST DEV_URL = 'https://boxin-dev-notification.azurewebsites.net/';
	CONST LOC_URL = 'http://localhost:5252/';
	CONST PROD_URL = 'https://boxin-prod-notification.azurewebsites.net/';

    public function __construct(PaymentRepository $repository, ExtendPaymentRepository $repository2)
    {
		$this->url        = (env('DB_DATABASE') == 'coredatabase') ? self::DEV_URL : self::PROD_URL;
        $this->repository = $repository;
        $this->repository2 = $repository2;
    }

    public function index()
    {
      $data = $this->repository->all();
      return view('payment.order.index', compact('data'));
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
      $data     = $this->repository->getById($id);
      return view('payment.order.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {

      // dd($request);
        $this->validate($request, [
            'status_id'  => 'required',
        ]);

        $order_id = $request->order_id;
        $status   = $request->status_id;

        DB::beginTransaction();
        try {
          $payment = $this->repository->find($id);
          // dd($payment);
          if (empty($payment)) {
            throw new Exception("Edit status order payment failed.");
          }

          $payment->status_id = intval($status);
          $payment->save();

          $order            = Order::find($order_id);
          $order->status_id = $status;
          $order->save();

          $po            = PickupOrder::where('order_id', $order_id)->first();
          $po->status_id = $status;
          $po->save();

          $array = array();
          $order_details = OrderDetail::where('order_id', $order_id)->get();
          foreach ($order_details as $key => $value) {
            $array[] = array(
              'room_or_box_id'       => $value->room_or_box_id,
              'types_of_box_room_id' => $value->types_of_box_room_id
            );
            $value->status_id = $status;
            $value->save();
          }

          if ($request->status_id == 8) {
            for ($i=0; $i < count($array); $i++) { 
              self::backToEmpty($array[$i]['types_of_box_room_id'], $array[$i]['room_or_box_id']);
            }
          }

          foreach ($order_details as $key => $value) {
            if ($request->status_id == 7 || $request->status_id == 8){
              $params['status_id']       = $status;
              $params['order_detail_id'] = $value->id;
              $userDevice = UserDevice::where('user_id', $order->user_id)->get();
              if(count($userDevice) > 0){
                  $response = Requests::post($this->url . 'api/confirm-payment/' . $order->user_id, [], $params, []);
              }
            }
          }

          DB::commit();
          return redirect()->route('payment.index')->with('success', 'Edit status order payment success.');
        } catch (Exception $th) {
          DB::rollback();
          return redirect()->route('payment.index')->with('error', $th->getMessage());
        }

    }

    protected function backToEmpty($types_of_box_room_id, $id)
    {
      if ($types_of_box_room_id == 1 || $types_of_box_room_id == "1") {
        // order box
        $box = Box::find($id);
        if ($box) {
          $box->status_id = 10;
          $box->save();
        }
        // Box::where('id', $id)->update(['status_id' => 10]);
      }
      else if ($types_of_box_room_id == 2 || $types_of_box_room_id == "2") {
        // order room
        // change status room to empty
        $box = SpaceSmall::find($id);
        if ($box) {
          $box->status_id = 10;
          $box->save();
        }
        // SpaceSmall::where('id', $id)->update(['status_id' => 10]);
      }
    }

    public function destroy($id)
    {

    }
    
    public function payment_extend()
    {
      $data = $this->repository2->all();
      return view('payment.extend.index', compact('data'));
    }

    public function payment_extend_edit($id)
    {
      $data = $this->repository2->getById($id);
      return view('payment.extend.edit', compact('data', 'id'));
    }

    public function payment_extend_update(Request $request, $id)
    {
      // dd($request);
      $this->validate($request, [
        'status_id'  => 'required',
      ]);

      $extend_id = $request->extend_id;
      $status    = $request->status_id;

      DB::beginTransaction();
      try {

        $payment            = $this->repository2->find($id);
        if (empty($payment)) {
          return redirect()->route('payment.extend')->with('error', 'Edit status extend order payment failed.');
        }
        $payment->status_id = intval($status);
        $payment->save();
        
        $ex_order_details = ExtendOrderDetail::find($extend_id);
        if ($ex_order_details) {
            $ex_order_details->status_id = intval($status);
            $ex_order_details->save();

            if ($request->status_id == 7) {
                $orderDetails           = OrderDetail::findOrFail($ex_order_details->order_detail_id);
                $orderDetails->amount   = $ex_order_details->total_amount;                              // total amount dari durasi baru dan lama
                $orderDetails->end_date = $ex_order_details->new_end_date;                              // durasi tanggal berakhir yang baru
                $orderDetails->duration = $ex_order_details->new_duration;                              // total durasi
                $orderDetails->save();
            }

            if ($request->status_id == 7 || $request->status_id == 8){
              $params['status_id'] =  $request->status_id;
              $params['order_detail_id'] = $ex_order_details->order_detail_id;
              $user_id = $ex_order_details->user_id;
              $userDevice = UserDevice::where('user_id', $user_id)->get();
              if(count($userDevice) > 0){
                  $response = Requests::post($this->url . 'api/confirm-payment/' . $user_id, [], $params, []);
              }
            }
        }

        DB::commit();
        return redirect()->route('payment.extend')->with('success', 'Edit status extend order payment success.');
      } catch (\Exception $th) {
        DB::rollback();
        return redirect()->route('payment.extend')->with('error', 'Edit status extend order payment failed.');
      }
      // $payment            = $this->repository2->find($id);
      // $payment->status_id = intval($status);
      // $payment->save();

      // if($payment){
      //     $ex_order_details = ExtendOrderDetail::find($extend_id);
      //     if ($ex_order_details) {
      //         $ex_order_details->status_id = intval($status);
      //         $ex_order_details->save();

      //         if ($request->status_id == 7) {
      //             $orderDetails           = OrderDetail::findOrFail($ex_order_details->order_detail_id);
      //             $orderDetails->amount   = $ex_order_details->total_amount;                              // total amount dari durasi baru dan lama
      //             $orderDetails->end_date = $ex_order_details->new_end_date;                              // durasi tanggal berakhir yang baru
      //             $orderDetails->duration = $ex_order_details->new_duration;                              // total durasi
      //             $orderDetails->save();
      //         }

      //         if ($request->status_id == 7 || $request->status_id == 8){
      //           $params['status_id'] =  $request->status_id;
      //           $params['order_detail_id'] = $ex_order_details->order_detail_id;
      //           $user_id = $ex_order_details->user_id;
      //           $userDevice = UserDevice::where('user_id', $user_id)->get();
      //           if(count($userDevice) > 0){
      //               $response = Requests::post($this->url . 'api/confirm-payment/' . $user_id, [], $params, []);
      //           }
      //         }
      //     }

      //     return redirect()->route('payment.extend')->with('success', 'Edit status extend order payment success.');
      // } else {
      //     return redirect()->route('payment.extend')->with('error', 'Edit status extend order payment failed.');
      // }
    }

}
