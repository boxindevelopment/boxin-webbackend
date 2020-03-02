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

class OrderController extends Controller
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
      return view('orders.index');
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

        $orderData = $this->repository->getData($args);

        $recordsTotal = count($orderData);

        $recordsFiltered = $this->repository->getCount($args);

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

        $validator = \Validator::make($request->all(), [
            'user_id'                   => 'required|exists:users,id',
            'area_id'                   => 'required|exists:areas,id',
            'types_of_pickup_id'        => 'required',
            'date'                      => 'required',
            'time'                      => 'required',
            'pickup_fee'                => 'required',
            "types_of_box_room_id"      => "required|array|min:1",
            "duration"                  => "required|array|min:1",
            "types_of_duration_id"      => "required|array|min:1",
        ]);
        if($validator->fails()) {
          return redirect()->route('order.create')->with('error', $validator->errors());
        }
        $data = $request->all();
        $user = User::find($request->user_id);

        DB::beginTransaction();
        try {
            $order                         = new Order;
            $order->user_id                = $request->user_id;
            $order->payment_expired        = Carbon::now()->addDays(1)->toDateTimeString();
            $order->payment_status_expired = 0;
            $order->area_id                = $request->area_id;
            $order->status_id              = 14;
            $order->total                  = 0;
            $order->voucher_amount         = 0;
            $order->qty                    = count($request->duration);
            $order->save();

            $order_id_today = $order->id;

            $amount = 0;
            $total = 0;
            $total_amount = 0;
            $id_name = '';

            foreach ($request->duration as $k => $v) {
                $a = $k+1;
                $order_detail                       = new OrderDetail;
                $order_detail->order_id             = $order->id;
                $order_detail->status_id            = 14;
                $order_detail->types_of_duration_id = $data['types_of_duration_id'][$k];
                $order_detail->types_of_box_room_id = $data['types_of_box_room_id'][$k];
                $order_detail->types_of_size_id     = $data['types_of_size_id'][$k];
                $order_detail->duration             = $v;
                $order_detail->start_date           = date("Y-m-d", strtotime(str_replace('/', '-', $request->date)));
                $order_detail->place                = 'warehouse';

                // weekly
                if ($order_detail->types_of_duration_id == 2 || $order_detail->types_of_duration_id == '2') {
                    $end_date               = $order_detail->duration*7;
                    $order_detail->end_date = date('Y-m-d', strtotime('+'.$end_date.' days', strtotime($order_detail->start_date)));
                }
                // monthly
                else if ($order_detail->types_of_duration_id == 3 || $order_detail->types_of_duration_id == '3') {
                    $order_detail->end_date = date('Y-m-d', strtotime('+'.$order_detail->duration.' month', strtotime($order_detail->start_date)));
                //days
                } else {
                    $order_detail->end_date = date('Y-m-d', strtotime('+'.$order_detail->duration.' days', strtotime($order_detail->start_date)));
                }


                // order box
                if ($order_detail->types_of_box_room_id == 1 || $order_detail->types_of_box_room_id == "1") {
                    $type = 'box';

                    // get box
                    $boxes = $this->boxes->getDatas(['status_id' => 10, 'area_id' => $request->area_id, 'types_of_size_id' => $data['types_of_size_id'][$k]]);
                    if(isset($boxes[0]->id)){
                        $id_name = $boxes[0]->id_name;
                        $room_or_box_id = $boxes[0]->id;
                        //change status box to fill
                        DB::table('boxes')->where('id', $room_or_box_id)->update(['status_id' => 9]);
                    } else {
                        throw new Exception('The box is not available.');
                        // return response()->json(['status' => false, 'message' => 'The box is not available.']);
                    }

                    // get price box
                    $price = $this->price->getPrice($order_detail->types_of_box_room_id, $order_detail->types_of_size_id, $order_detail->types_of_duration_id, $order->area_id);

                    if ($price){
                        $amount = $price->price * $order_detail->duration;
                    } else {
                        // change status room to empty when order failed to create
                        Box::where('id', $room_or_box_id)->update(['status_id' => 10]);
                        throw new Exception('Not found price box.');
                        // return response()->json(['status' => false, 'message' => 'Not found price box.']);
                    }
                }

                // order room
                if ($order_detail->types_of_box_room_id == 2 || $order_detail->types_of_box_room_id == "2") {
                    $type = 'space';
                    // get space small
                    $spaceSmall = $this->spaceSmall->getDatas(['status_id' => 10, 'area_id' => $request->area_id, 'types_of_size_id' => $data['types_of_size_id'][$k]]);
                    if(!empty($spaceSmall->id)){
                        $code_space_small = $spaceSmall->code_space_small;
                        $room_or_box_id = $spaceSmall->id;
                        //change status room to fill
                        SpaceSmall::where('id', $room_or_box_id)->update(['status_id' => 9]);
                    } else {
                        // change status room to empty when order failed to create
                        throw new Exception('The room is not available.');
                        // return response()->json(['status' => false, 'message' => 'The room is not available.']);
                    }

                    // get price room
                    $price = $this->price->getPrice($order_detail->types_of_box_room_id, $order_detail->types_of_size_id, $order_detail->types_of_duration_id, $order->area_id);

                    if ($price) {
                        $amount = $price->price * $order_detail->duration;
                    } else {
                        // change status room to empty when order failed to create
                        SpaceSmall::where('id', $room_or_box_id)->update(['status_id' => 10]);
                        throw new Exception('Not found price room.');
                        // return response()->json([
                        //     'status' =>false,
                        //     'message' => 'Not found price room.'
                        // ], 401);
                    }
                }

                $order_detail->name           = 'New '. $type .' '. $a;
                $order_detail->room_or_box_id = $room_or_box_id;
                $order_detail->amount         = $amount;
                $order_detail->id_name        = date('Ymd') . $order->id;

                $total += $order_detail->amount;
                $order_detail->save();

            }

            $pickup                     = new PickupOrder;
            $pickup->date               = date("Y-m-d", strtotime(str_replace('/', '-', $request->date)));
            $pickup->order_id           = $order_id_today;
            $pickup->types_of_pickup_id = $request->types_of_pickup_id[0];
            $pickup->address            = $request->address_id;
            $pickup->time               = $request->time;
            $pickup->note               = $request->note;
            $pickup->pickup_fee         = $request->pickup_fee;
            $pickup->status_id          = 14;
            $pickup->save();

            //update total order
            $total_amount += $total;
            if($request->types_of_pickup_id[0] == 1){
                $total_all = $total_amount + intval($request->pickup_fee);
            } else {
                $total_all = $total_amount;
            }
            $tot = $total_all;

            Order::where('id', $order->id)->update(['total' => $tot, 'deliver_fee' => intval($request->pickup_fee)]);
            // Transaction Log Create
            $transactionLog = new TransactionLog;
            $transactionLog->user_id                        = $request->user_id;
            $transactionLog->transaction_type               = 'start storing';
            $transactionLog->order_id                       = $order->id;
            $transactionLog->status                         = 'Pend Payment';
            $transactionLog->location_warehouse             = 'warehouse';
            $transactionLog->location_pickup                = 'house';
            $transactionLog->datetime_pickup                =  Carbon::now();
            $transactionLog->types_of_box_space_small_id    = $data['types_of_box_room_id'][0];
            $transactionLog->space_small_or_box_id          = $room_or_box_id;
            $transactionLog->amount                         = $tot;
            $transactionLog->created_at                     =  Carbon::now();
            $transactionLog->save();


            // MessageInvoice::dispatch($order, $user)->onQueue('processing');
            // $response = Requests::post($this->url . 'api/payment-email/' . $order->id, [], $params, []);
            // $client = new \GuzzleHttp\Client();
            // $response = $client->request('POST', env('APP_NOTIF') . 'api/payment-email/' . $order->id);
            DB::commit();
        } catch (Exception $e) {
            // delete order when order_detail failed to create
            // Order::where('id', $order->id)->delete();
            DB::rollback();
            return redirect()->route('order.create')->with('error', $e->getMessage());
        }

        return redirect()->route('order.index');
    }

    public function show($id)
    {
      abort('404');
    }

    public function orderDetail($id)
    {
      $detail_order     = OrderDetail::where('order_id',$id)->orderBy('id')->get();
      $url = route('order.index');
      return view('orders.list-order-detail', compact('detail_order', 'id', 'url'));
    }

    public function orderDetailBox($id)
    {
        $order_detail       = OrderDetail::find($id);
        $detail             = $this->orderDetails->getOrderDetail($order_detail->order_id);
        $detail_order_box   = OrderDetailBox::where('order_detail_id',$id)->orderBy('id')->get();
      return view('orders.list-order-detail-box', compact('detail_order_box', 'id', 'detail'));
    }

    public function updatePlace(Request $request, $id)
    {
        $orderDetail       = OrderDetail::find($id);
        $orderDetail->place = $request->place;
        $orderDetail->save();
        return redirect()->route('order.orderDetailBox', ['id' => $id])->with('success', 'Data Place successfully updated!');
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $data = Order::findOrFail($id);

        if($data){
            $detail_order       = OrderDetail::where('order_id', $id)->get();
            $count_detail_order = count($detail_order);
            for ($i = 0; $i < $count_detail_order ; $i++) {
                //delete order detail box
                $detail_order_box       = OrderDetailBox::where('order_detail_id', $detail_order[$i]->id)->get();
                $count_detail_order_box = count($detail_order_box);
                for ($a = 0; $a < $count_detail_order_box ; $a++) {
                    $detailOrderBox = OrderDetailBox::findOrFail($detail_order_box[$a]->id);
                    $detailOrderBox->delete();
                }
                //delete order detail
                $detailOrder = OrderDetail::findOrFail($detail_order[$i]->id);
                $detailOrder->delete();
            }
            //delete pickup order
            $pickup_order       = PickupOrder::where('order_id', $id)->get();
            $count_pickup_order = count($pickup_order);
            for ($b = 0; $b < $count_pickup_order ; $b++) {
                $pickupOrder = PickupOrder::findOrFail($pickup_order[$b]->id);
                $pickupOrder->delete();
            }
            $data->delete();
            return redirect()->route('order.index')->with('success', 'Data order successfully deleted!');
        } else {
            return redirect()->route('order.index')->with('error', 'Delete data order failed!');
        }

    }
}
