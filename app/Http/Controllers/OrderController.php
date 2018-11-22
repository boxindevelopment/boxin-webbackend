<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\OrderDetailBox;
use App\Model\PickupOrder;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $order   = $this->repository->all();
      return view('orders.index', compact('order'));
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

    public function orderDetail($id)
    {
      $detail_order     = OrderDetail::where('order_id',$id)->orderBy('id')->get();
      return view('orders.list-order-detail', compact('detail_order', 'id'));
    }

    public function orderDetailBox($id)
    {
      $detail_order_box     = OrderDetailBox::where('order_detail_id',$id)->orderBy('id')->get();
      return view('orders.list-order-detail-box', compact('detail_order_box', 'id'));
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $data = Order::findOrFail($id);
        
        if($data){
            $detail_order       = OrderDetail::where('order_id', $id)->get();
            $count_detail_order = count($detail_order);
            for ($i = 0; $i < $count_detail_order ; $i++) {
                //delete order detail box
                $detail_order_box       = OrderDetailBox::where('order_detail_id', $detail_order[$i]->id)->get();
                $count_detail_order_box = count($detail_order_box);
                for ($a = 0; $a < $count_detail_order_box ; $a++) {
                    $detailOrderBox = OrderDetailBox::findOrFail($detail_order_box[$a]->id);
                    $detailOrderBox->delete();
                }
                //delete order detail
                $detailOrder = OrderDetail::findOrFail($detail_order[$i]->id);
                $detailOrder->delete();
            }
            //delete pickup order
            $pickup_order       = PickupOrder::where('order_id', $id)->get();
            $count_pickup_order = count($pickup_order);
            for ($b = 0; $b < $count_pickup_order ; $b++) {
                $pickupOrder = PickupOrder::findOrFail($pickup_order[$b]->id);
                $pickupOrder->delete();
            }
            $data->delete();
            return redirect()->route('order.index')->with('success', 'Data order successfully deleted!');
        } else {
            return redirect()->route('order.index')->with('error', 'Delete data order failed!');
        }
    
    }
}
