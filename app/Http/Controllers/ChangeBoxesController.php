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

        $change = ChangeBox::find($id);

        DB::beginTransaction();
        try {
          //code...
          $status               = $request->status_id;
          $change               = ChangeBox::find($id);
          $change->status_id    = $status;
          $change->driver_name  = $request->driver_name;
          $change->driver_phone = $request->driver_phone;
          $change->save();

          if ($status == 12) {
            $cbd = ChangeBoxDetail::where('change_box_id', $id)->pluck('order_detail_box_id')->toArray();
            if (count($cbd) > 0) {
              OrderDetailBox::whereIn('id', $cbd)->update(['status_id' => 21]);
            }
          }
          
          DB::commit();
          return redirect()->route('change-box.index')->with('success', 'Edit Data Return Boxes success.');
        } catch (Exception $th) {
          //throw $th;
          DB::rollback();
          // return redirect()->route('change-box.index')->with('error', $th->getMessage());
          return redirect()->route('change-box.index')->with('error', 'Edit Data Return Boxes failed.');
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
