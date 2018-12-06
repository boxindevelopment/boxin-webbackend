<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\PickupOrder;
use App\Repositories\PaymentRepository;

class PaymentController extends Controller
{
    protected $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
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
        $this->validate($request, [
            'status_id'  => 'required',
        ]);

        $order_id               = $request->order_id; 
        $status                 = $request->status_id;

        $payment                 = $this->repository->find($id);
        $payment->status_id      = intval($status);
        $payment->save();

        if($payment){
            $order                  = Order::find($order_id);
            $order->status_id       = $status;
            $order->save();

            $po                     = PickupOrder::where('order_id', $order_id)->first();            
            $pickuporder            = PickupOrder::find($po->id);
            $pickuporder->status_id = $status;
            $pickuporder->save();

            $order_details          = OrderDetail::where('order_id', $order_id)->get();
            for ($i = 0; $i < count($order_details); $i++) {
                $order_detail            = OrderDetail::find($order_details[$i]->id);
                $order_detail->status_id = $status;
                $order_detail->save();
            }

            return redirect()->route('payment.index')->with('success', 'Edit status order payment success.');
        } else {
            return redirect()->route('payment.index')->with('error', 'Edit status order payment failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}