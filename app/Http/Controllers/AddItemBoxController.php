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
      return view('additem.index');
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
        $args['orderColumns'] = ($columns[$orderNumber]['name']) ? $columns[$orderNumber]['name'] : 'name';

        $addItemBox = $this->repository->getData($args);

        $recordsTotal = count($addItemBox);

        $recordsFiltered = $this->repository->getCount($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($addItemBox as $arrVal) {
            $no++;
            if($arrVal->types_of_pickup_id == 1){
              $label1  = 'label-warning';
              $name    = 'Deliver to user';
          }else if($arrVal->types_of_pickup_id == 2){
              $label1  = 'label-primary';
              $name    = 'User pickup';
            }

            if($arrVal->status_id == 19){
              $label = 'label-warning';
          }else if($arrVal->status_id == 22 || $arrVal->status_id == 5){
              $label = 'label-success';
            }else{
              $label = 'label-danger';
            }

            $arr = array(
                      'no'                      => $no,
                      'id'                      => $arrVal->id,
                      'types_of_pickup_id'      => $arrVal->types_of_pickup_id,
                      'created_at'              => date("d-m-Y", strtotime($arrVal->created_at)),
                      'coming_date'             => date("d-m-Y", strtotime($arrVal->date)) . '( ' . $arrVal->time_pickup . ' )',
                      'user_fullname'           => $arrVal->first_name . ' ' . $arrVal->last_name,
                      'items'                   => count($arrVal->items),
                      'name'                    => $name,
                      'label1'                  => $label1,
                      'label'                   => $label,
                      'status_name'             => $arrVal->status_name);
                $arr_data['data'][] = $arr;

            }

            $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
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
