<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrderDetailRepository;
use App\Model\OrderDetail;

class OrderDetailController extends Controller
{
    protected $repository;

    public function __construct(OrderDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $order   = $this->repository->all();
      return view('storage.index', compact('order'));
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

        $storage = $this->repository->getData($args);

        $recordsTotal = count($storage);

        $recordsFiltered = $this->repository->getCount($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($storage as $arrVal) {
            $no++;
            $added = ($arrVal['duration_alias'] == '6month') ? 'x' : ' ';
            $arr = array(
                      'no' => $no,
                      'id' => $arrVal['order_id'],
                      'date' => date("d-m-Y", strtotime($arrVal['start_date'])) . ' - ' . date("d-m-Y", strtotime($arrVal['end_date'])),
                      'user_fullname' => $arrVal['first_name'] . ' ' . $arrVal['last_name'],
                      'id_name' => $arrVal['id_name'],
                      'duration' => $arrVal['duration'] . $added . $arrVal['duration_alias'],
                      'place' => ($arrVal['place'] != 'warehouse') ? 'user' : $arrVal['place'], //
                      'status_name' => $arrVal['status_name'], //
                      'amount' => number_format($arrVal['amount'], 0, '', '.'));
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

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {

    }

    public function orderDetailBox($id)
    {
        $detail             = $this->repository->getOrderDetail($id);
        $detail_order_box   = $this->repository->getDetailBox($id);
        return view('storage.box-detail', compact('detail_order_box', 'id', 'detail'));
    }

    public function orderDetail($id)
    {
      $detail_order  = OrderDetail::where('id',$id)->orderBy('id')->get();
      $url = route('payment.extend');
      return view('orders.list-order-detail', compact('detail_order', 'id', 'url'));
    }

}
