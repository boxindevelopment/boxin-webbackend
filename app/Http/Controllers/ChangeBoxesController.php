<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ChangeBox;
use App\Model\ChangeBoxDetail;
use App\Model\OrderDetail;
use App\Model\OrderDetailBox;
use App\Repositories\ChangeBoxRepository;
use DB;
use Exception;

class ChangeBoxesController extends Controller
{
    protected $repository;

    public function __construct(ChangeBoxRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $data = $this->repository->all();
      return view('changebox.index', compact('data'));
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
      return view('changebox.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status_id'  => 'required',
        ]);
        $status               = $request->status_id;
        DB::beginTransaction();
        try {
          //code...
          $change = ChangeBox::find($id);
          if (empty($change)) {
            throw new Exception("Edit Data Change Boxes failed.");
            // return redirect()->route('add-item.index')->with('error', 'Edit Data Add Item Boxes failed.');
          }

          $now_date = Carbon::now();
          $execution_date = Carbon::parse($change->date);
          if ($now_date->lt($execution_date)) {
            throw new Exception("Edit Data Change Boxes failed, Tanggal tidak sesuai.");
          }

          $change->status_id    = $status;
          if ($status == 2) {
            $change->driver_name  = $request->driver_name;
            $change->driver_phone = $request->driver_phone;
            $change->save();
          } else {
            $change->save();
          }

          if ($status == 12) {
            $cbd = ChangeBoxDetail::where('change_box_id', $id)->pluck('order_detail_box_id')->toArray();
            if (count($cbd) > 0) {
              OrderDetailBox::whereIn('id', $cbd)->update(['status_id' => 21]);
            }
          }
          
          DB::commit();
          return redirect()->route('change-box.index')->with('success', 'Edit Data Change Boxes success.');
        } catch (Exception $th) {
          //throw $th;
          DB::rollback();
          return redirect()->route('change-box.index')->with('error', $th->getMessage());
          // return redirect()->route('change-box.index')->with('error', 'Edit Data Return Boxes failed.');
        }
        
        // if($change){
        //     // $order               = OrderDetail::find($request->order_detail_id);
        //     // $order->status_id    = $status == '12' ? '4' : $status;
        //     // $order->save();
            
        // } else {
            
        // }
    }

    public function destroy($id)
    {

    }
}
