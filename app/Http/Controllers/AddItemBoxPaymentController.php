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
    return view('payment.additem.index');
  }

  public function getAjax(Request $request)
  {

      $search = $request->input("search");
      $args = array();
      $args['searchRegex'] = ($search['regex']) ? $search['regex'] : false;
      $args['searchValue'] = ($search['value']) ? $search['value'] : '';
      $args['draw'] = ($request->input('draw')) ? intval($request->input('draw')) : 0;
      $args['length'] =  ($request->input('length')) ? intval($request->input('length')) : 10;
      $args['start'] =  ($request->input('start')) ? intval($request->input('start')) : 0;

      $order = $request->input("order");
      $args['orderDir'] = ($order[0]['dir']) ? $order[0]['dir'] : 'DESC';
      $orderNumber = ($order[0]['column']) ? $order[0]['column'] : 0;
      $columns = $request->input("columns");
      $args['orderColumns'] = ($columns[$orderNumber]['name']) ? $columns[$orderNumber]['name'] : 'id_name';

      $addItemBoxPayment = $this->repository->getData($args);

      $recordsTotal = count($addItemBoxPayment);

      $recordsFiltered = $this->repository->getCount($args);

      $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
      $arr_data = array();
      $no = 0;
      foreach ($addItemBoxPayment as $arrVal) {
          $no++;

            if($arrVal['status_id'] == 14){
              $label = 'label-warning';
          }else if($arrVal['status_id'] == 5){
              $label = 'label-success';
          }else if($arrVal['status_id'] == 7){
              $label = 'label-success';
          }else if($arrVal['status_id'] == 6){
              $label = 'label-danger';
          } else {
              $label = 'label-warning';
          }

          $arr = array(
                    'no' => $no,
                    'id' => $arrVal['id'],
                    'created_at' => date("d-m-Y", strtotime($arrVal['created_at'])),
                    'user_fullname' => $arrVal['first_name'] . ' ' . $arrVal['last_name'],
                    'id_name' => $arrVal['id_name'],
                    'label' => $label, //
                    'status_id' => $arrVal['status_id'], //
                    'status_name' => $arrVal['status_name'], //
                    'image_transfer' => $arrVal['image_transfer'], //
                    'amount' => number_format($arrVal['amount'], 0, '', '.'));
              $arr_data['data'][] = $arr;

          }

          $arrOut = array_merge($arrOut, $arr_data);
      echo(json_encode($arrOut));
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
