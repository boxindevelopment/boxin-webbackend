<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AddItem;
use App\Model\AddItemBox;
use App\Model\AddItemBoxPayment;
use App\Repositories\AddItemBoxRepository;
use Auth;
use Validator;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\OrderDetailBox;
use DB;
use Exception;
use Carbon\Carbon;

class AddItemBoxController extends Controller
{
    protected $repository;

    public function __construct(AddItemBoxRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $data = $this->repository->all();
      return view('additem.index', compact('data'));
    }

    public function edit($id)
    {
      $data = $this->repository->getById($id);
      return view('additem.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
      $this->validate($request, ['status_id'  => 'required']);
      $status = $request->status_id;
      DB::beginTransaction();
      try {

        $additem = AddItemBox::find($id);
        if (empty($additem)) {
          throw new Exception("Edit Data Add Item Boxes failed.");
          // return redirect()->route('add-item.index')->with('error', 'Edit Data Add Item Boxes failed.');
        }

        $now_date = Carbon::now();
        $execution_date = Carbon::parse($additem->date);
        if ($now_date->lt($execution_date)) {
          throw new Exception("Edit Data Add Item Boxes failed, Tanggal tidak sesuai.");
          // return redirect()->route('add-item.index')->with('error', 'Edit Data Add Item Boxes failed, Tanggal tidak sesuai.');
        }

        // sudah finished
        if ($additem->status_id == 12) {
          throw new Exception("Edit Data Add Item Boxes failed, Sudah finished.");
        }

        $additem->status_id = $status;
        if ($status == 2) {
          $additem->driver_name  = $request->driver_name;
          $additem->driver_phone = $request->driver_phone;
          $additem->save();
        } else {
          $additem->save();
        }

        // insert to order detail boxes table 
        if ($status == 12 || $status == '12') {
          $order_detail_id = $additem->order_detail_id;
          foreach ($additem->items as $key => $value) {
            OrderDetailBox::create([
              'order_detail_id' => $order_detail_id,
              'category_id'     => $value->category_id,
              'item_name'       => $value->item_name,
              'item_image'      => $value->item_image,
              'note'            => $value->note,
              'status_id'       => 9
            ]);
          }
        }
        
        DB::commit();
      } catch (\Exception $th) {
        DB::rollback();
        return redirect()->route('add-item.index')->with('error', $th->getMessage());
      }
      
      return redirect()->route('add-item.index')->with('success', 'Edit Data Add Item Boxes success.');
    }

}
