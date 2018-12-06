<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ReturnBoxPayment;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\ReturnBoxes;
use App\Repositories\ReturnBoxPaymentRepository;

class ReturnBoxPaymentController extends Controller
{
    protected $repository;

    public function __construct(ReturnBoxPaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {      
      $data = $this->repository->all();
      return view('payment.return_box.index', compact('data'));
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
      return view('payment.return_box.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status_id'  => 'required',
        ]);

        $order_detail_id        = $request->order_detail_id; 
        $status                 = $request->status_id;
        
        $orderdetail            = OrderDetail::find($order_detail_id);
        $orderdetail->status_id = $status;
        $orderdetail->save();

        $order                  = Order::find($orderdetail->id);
        $order->status_id       = $status;
        $order->save();
        
        $payment                 = $this->repository->find($id);
        $payment->status_id      = $status;
        $payment->save();

        if($payment){
            return redirect()->route('returnboxpayment.index')->with('success', 'Edit status order return box payment success.');
        } else {
            return redirect()->route('returnboxpayment.index')->with('error', 'Edit status order return box payment failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}
