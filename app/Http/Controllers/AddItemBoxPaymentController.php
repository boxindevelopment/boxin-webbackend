<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AddItem;
use App\Model\AddItemBox;
use App\Model\AddItemBoxPayment;
use App\Repositories\AddItemBoxPaymentRepository;
use Auth;
use Validator;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\OrderDetailBox;
use DB;
use Exception;

class AddItemBoxPaymentController extends Controller
{
  protected $repository;

  public function __construct(AddItemBoxPaymentRepository $repository)
  {
      $this->repository = $repository;
  }

  public function index()
  {
    $data = $this->repository->all();
    return view('payment.additem.index', compact('data'));
  }

  public function edit($id)
  {
    $data = $this->repository->getById($id);
    return view('payment.additem.edit', compact('data', 'id'));
  }

  public function update(Request $request, $id)
  {
      $this->validate($request, ['status_id' => 'required']);

      $order_detail_id = $request->order_detail_id;
      $add_item_box_id = $request->add_item_box_id;
      $status          = $request->status_id;

      DB::beginTransaction();
      try {
        $payment                 = $this->repository->find($id);
        $payment->status_id      = $status;
        $payment->save();

        //change status on table add_item
        $add_item = AddItemBox::find($add_item_box_id);
        $add_item->status_id = $status;
        $add_item->save();
        
        DB::commit();
        return redirect()->route('add-item-payment.index')->with('success', 'Edit status change box payment success.');
      } catch (Exception $th) {
        DB::rollback();
        return redirect()->route('add-item-payment.index')->with('error', 'Edit status change box payment failed.');
      }
      // if($payment){
      //     return redirect()->route('change-box-payment.index')->with('success', 'Edit status change box payment success.');
      // } else {
      //     return redirect()->route('change-box-payment.index')->with('error', 'Edit status change box payment failed.');
      // }
  }

}
