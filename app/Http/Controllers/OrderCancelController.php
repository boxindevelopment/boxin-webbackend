<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Box;
use App\Model\Order;
use App\Model\User;
use App\Model\OrderDetail;
use App\Model\OrderDetailBox;
use App\Model\PickupOrder;
use App\Model\SpaceSmall;
use App\Model\TransactionLog;
use App\Repositories\BoxRepository;
use App\Repositories\PriceRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\SpaceSmallRepository;
use Carbon\Carbon;
use DB;
use Exception;

class OrderCancelController extends Controller
{
    protected $repository;
    protected $orderDetails;
    protected $boxes;
    protected $spaceSmalls;
    protected $price;

    public function __construct(OrderRepository $repository,
                                OrderDetailRepository $orderDetails,
                                BoxRepository $boxes,
                                SpaceSmallRepository $spaceSmall,
                                PriceRepository $price)
    {
        $this->repository   = $repository;
        $this->orderDetails = $orderDetails;
        $this->boxes        = $boxes;
        $this->spaceSmall   = $spaceSmall;
        $this->price        = $price;
    }

    public function index()
    {
      return view('order-cancel.index');
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

        $orderData = $this->repository->getDataCancel($args);

        $recordsTotal = count($orderData);

        $recordsFiltered = $this->repository->getCountCancel($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($orderData as $arrVal) {
            $no++;
            $arr = array(
                      'no' => $no,
                      'id' => $arrVal['id'],
                      'created_at' => date("d-m-Y", strtotime($arrVal['created_at'])),
                      'user_fullname' => $arrVal['first_name'] . ' ' . $arrVal['last_name'],
                      'area_name' => $arrVal['area_name'],
                      'voucher_code' => $arrVal['voucher_code'], //
                      'status_id' => $arrVal['status_id'], //
                      'voucher_amount' => ($arrVal['voucher_amount']) ? number_format($arrVal['voucher_amount'], 0, '', '.') : 0, //
                      'total' => number_format($arrVal['total'], 0, '', '.'));
                $arr_data['data'][] = $arr;

            }

            $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
    }

    public function create()
    {
      // $order   = $this->repository->all();
      return view('orders.create');
    }

    public function store(Request $request)
    {
        abort('404');
    }

    public function show($id)
    {
      abort('404');
    }

    public function orderDetail($id)
    {
      $detail_order     = OrderDetail::where('order_id',$id)->orderBy('id')->get();
      $url = route('order.cancel.index');
      return view('order-cancel.list-order-detail', compact('detail_order', 'id', 'url'));
    }

    public function orderDetailBox($id)
    {
        $order_detail       = OrderDetail::find($id);
        $detail             = $this->orderDetails->getOrderDetail($order_detail->order_id);
        $detail_order_box   = OrderDetailBox::where('order_detail_id',$id)->orderBy('id')->get();
      return view('order-cancel.list-order-detail-box', compact('detail_order_box', 'id', 'detail'));
    }

    public function update(Request $request, $id)
    {
        abort('404');
    }

    public function destroy($id)
    {
        abort('404');

    }
}
