<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ReturnBoxes;
use App\Model\Order;
use App\Model\OrderDetail;
use Carbon;

class ReturnBoxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data1   = ReturnBoxes::select('return_boxes.*', 'users.first_name',  'users.last_name')
        ->leftJoin('order_details','order_details.id','=','return_boxes.order_detail_id')
        ->leftJoin('orders','orders.id','=','order_details.order_id')
        ->leftJoin('users','users.id','=','orders.user_id')
        ->where('return_boxes.types_of_pickup_id', 1)
        ->orderBy('return_boxes.id', 'DESC')
        ->get();
      $data2   = ReturnBoxes::select('return_boxes.*', 'users.first_name',  'users.last_name')
        ->leftJoin('order_details','order_details.id','=','return_boxes.order_detail_id')
        ->leftJoin('orders','orders.id','=','order_details.order_id')
        ->leftJoin('users','users.id','=','orders.user_id')
        ->where('return_boxes.types_of_pickup_id', 2)
        ->orderBy('return_boxes.id', 'DESC')
        ->get();
      return view('returnbox.index', compact('data1', 'data2'));
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
      $data     = ReturnBoxes::where('id',$id)->get();
      return view('returnbox.edit', compact('data', 'id'));
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

        $return                 = ReturnBoxes::find($id);
        $return->status_id      = $request->status_id;
        $return->driver_name    = $request->driver_name;
        $return->driver_phone   = $request->driver_phone;
        $return->save();

        if($return){
            return redirect()->route('return.index')->with('success', 'Edit Data Return Boxes success.');
        } else {
            return redirect()->route('return.index')->with('error', 'Edit Data Return Boxes failed.');
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
