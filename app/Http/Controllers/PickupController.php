<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PickupOrder;
use App\Model\Order;
use App\Model\OrderDetail;
use Carbon;
use DB;

class PickupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $pickup   = PickupOrder::select('pickup_orders.*', 'users.first_name',  'users.last_name')
        ->leftJoin('orders','orders.id','=','pickup_orders.order_id')
        ->leftJoin('users','users.id','=','orders.user_id')
        ->where('pickup_orders.status_id', '!=', 4)
        ->orderBy('pickup_orders.status_id', 'DESC')
        ->orderBy('id', 'ASC')
        ->get();
      return view('pickup.index', compact('pickup'));
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
    public function edit($id)
    {
      $pickup     = PickupOrder::select('pickup_orders.*')->where('id',$id)->get();
      return view('pickup.edit', compact('pickup', 'id'));
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
        $this->validate($request, [
            'status_id'  => 'required',
        ]);

        $order_id               = $request->order_id; 
        $status                 = $request->status_id;
        
        $order                  = Order::find($order_id);
        $order->status_id       = $status;
        $order->save();

        $order_details          = OrderDetail::where('order_id', $order_id)->get();
        $count                  = count($order_details);
        for ($i = 0; $i < $count; $i++) {
            $order_detail            = OrderDetail::find($order_details[$i]->id);
            $order_detail->status_id = $status;
            $order_detail->save();
        }

        $pickup                 = PickupOrder::find($id);
        $pickup->status_id      = $status;
        $pickup->driver_name    = $request->driver_name;
        $pickup->driver_phone   = $request->driver_phone;
        $pickup->save();

        if($pickup){
            return redirect()->route('pickup.index')->with('success', 'Edit Data Pickup Order success.');
        } else {
            return redirect()->route('pickup.index')->with('error', 'Edit Data Pickup Order failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
    }
}
