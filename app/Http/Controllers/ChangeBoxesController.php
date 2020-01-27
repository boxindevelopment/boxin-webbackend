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
use Carbon\Carbon;

class ChangeBoxesController extends Controller
{
    protected $repository;

    public function __construct(ChangeBoxRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      return view('changebox.index');
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

        $changeBoxes = $this->repository->getData($args);

        $recordsTotal = count($changeBoxes);

        $recordsFiltered = $this->repository->getCount($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($changeBoxes as $arrVal) {
            $no++;
            if($arrVal['types_of_pickup_id'] == 1){
              $label1  = 'label-warning';
              $name    = 'Deliver to user';
          }else if($arrVal['types_of_pickup_id'] == 2){
              $label1  = 'label-primary';
              $name    = 'User pickup';
            }

            if($arrVal['status_id'] == 19){
              $label = 'label-warning';
          }else if($arrVal['status_id'] == 22 || $arrVal['status_id'] == 5){
              $label = 'label-success';
            }else{
              $label = 'label-danger';
            }

            $arr = array(
                      'no'                      => $no,
                      'id'                      => $arrVal['id'],
                      'types_of_pickup_id'      => $arrVal['types_of_pickup_id'],
                      'created_at'              => date("d-m-Y", strtotime($arrVal['created_at'])),
                      'coming_date'             => date("d-m-Y", strtotime($arrVal['date'])) . '( ' . $arrVal['time_pickup'] . ' )',
                      'user_fullname'           => $arrVal['first_name'] . ' ' . $arrVal['last_name'],
                      'id_name'                 => $arrVal['id_name'],
                      'customer_name'           => $arrVal['first_name'] . ' ' . $arrVal['last_name'] . '<br>' . $arrVal['id_name'],
                      'name'                    => $name,
                      'label1'                  => $label1,
                      'label'                   => $label,
                      'status_name'             => $arrVal['status_name']);
                $arr_data['data'][] = $arr;

            }

            $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
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

          // sudah finished
          if ($change->status_id == 12) {
            throw new Exception("Edit Data Change Boxes failed, Sudah finished.");
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
