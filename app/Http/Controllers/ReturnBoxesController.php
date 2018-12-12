<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ReturnBoxes;
use App\Model\OrderDetail;
use App\Model\Box;
use App\Model\Space;
use App\Repositories\ReturnBoxesRepository;

class ReturnBoxesController extends Controller
{
    protected $repository;

    public function __construct(ReturnBoxesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $data   = $this->repository->all();
      return view('returnbox.index', compact('data'));
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
      return view('returnbox.edit', compact('data', 'id'));
    }

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
            $order_detail              = OrderDetail::find($request->order_detail_id);
            $order_detail->status_id   = $request->status_id == '12' ? '18' : $request->status_id;
            $order_detail->save();

            //change status box/room to 10 (empty)
            if($request->status_id == '12'){
                //box
                if($order_detail->types_of_box_room_id == 1) {
                    $box = Box::find($order_detail->room_or_box_id);
                    $box->status_id = 10;
                    $box->save();
                }
                //room
                else if ($order_detail->types_of_box_room_id == 2) {
                    $room = Room::find($order_detail->room_or_box_id);
                    $room->status_id = 10;
                    $room->save();
                }
            }
            
            return redirect()->route('return.index')->with('success', 'Edit Data Return Boxes success.');
        } else {
            return redirect()->route('return.index')->with('error', 'Edit Data Return Boxes failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}
