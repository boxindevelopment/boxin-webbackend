<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
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
      $data     = $this->repository->find($id);
      return view('payment.order.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        // $this->validate($request, [
        //     'status_id'  => 'required',
        // ]);

        // $order_id               = $request->order_id; 
        // $status                 = $request->status_id;
        
        // $order                  = Order::find($order_id);
        // $order->status_id       = $status;
        // $order->save();

        // $order_details          = OrderDetail::where('order_id', $order_id)->get();
        // $count                  = count($order_details);
        // for ($i = 0; $i < $count; $i++) {
        //     $order_detail            = OrderDetail::find($order_details[$i]->id);
        //     $order_detail->status_id = $status;
        //     $order_detail->save();
        // }

        // $pickup                 = PickupOrder::find($id);
        // $pickup->status_id      = $status;
        // $pickup->driver_name    = $request->driver_name;
        // $pickup->driver_phone   = $request->driver_phone;
        // $pickup->pickup_fee     = $request->pickup_fee;
        // $pickup->save();

        // if($pickup){
        //     return redirect()->route('pickup.index')->with('success', 'Edit Data Pickup Order success.');
        // } else {
        //     return redirect()->route('pickup.index')->with('error', 'Edit Data Pickup Order failed.');
        // }
    }

    public function destroy($id)
    {
      
    }
}
