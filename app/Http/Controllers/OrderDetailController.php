<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\OrderDetail;
use App\Model\OrderDetailBox;
use App\Model\PickupOrder;
use App\Repositories\OrderDetailRepository;

class OrderDetailController extends Controller
{
    protected $repository;

    public function __construct(OrderDetailRepository $repository)
    {
        $this->repository = $repository;
    }/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $order   = $this->repository->all();
      return view('storage.index', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      abort('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      abort('404');   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function orderDetail($id)
    {
      $detail_order     = OrderDetail::where('order_id',$id)->orderBy('id')->get();
      return view('orders.list_order_detail', compact('detail_order', 'id'));
    }

    public function orderDetailBox($id)
    {
      $detail_order_box     = OrderDetailBox::where('order_detail_id',$id)->orderBy('id')->get();
      return view('orders.list_order_detail_box', compact('detail_order_box', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
