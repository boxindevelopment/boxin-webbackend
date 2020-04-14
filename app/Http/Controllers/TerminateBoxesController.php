<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ReturnBoxes;
use App\Model\OrderDetail;
use App\Model\Order;
use App\Model\Box;
use App\Model\Room;
use App\Model\Space;
use App\Model\SpaceSmall;
use App\Model\UserDevice;
use App\Repositories\ReturnBoxesRepository;
use Requests;
use DB;
use Exception;
use Carbon\Carbon;

class TerminateBoxesController extends Controller
{
    protected $repository;

	private $url;
	CONST DEV_URL = 'https://boxin-dev-notification.azurewebsites.net/';
	CONST LOC_URL = 'http://localhost:5252/';
	CONST PROD_URL = 'https://boxin-prod-notification.azurewebsites.net/';

    public function __construct(ReturnBoxesRepository $repository)
    {
		$this->url        = (env('DB_DATABASE') == 'coredatabase') ? self::DEV_URL : self::PROD_URL;
        $this->repository = $repository;
    }

    public function index()
    {

      $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
      $terminateToday = ReturnBoxes::where('date', $today)->where('status_id', 16)->count();
      $terminateAll = ReturnBoxes::where('status_id', 16)->count();
      $terminateSuccess = ReturnBoxes::where('status_id', 28)->count();

      return view('terminate.index', compact('terminateToday', 'terminateAll', 'terminateSuccess'));
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

        $returnBoxes = $this->repository->getData($args);

        $recordsTotal = count($returnBoxes);

        $recordsFiltered = $this->repository->getCount($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($returnBoxes as $arrVal) {
            $no++;
            if($arrVal->types_of_pickup_id == 1){
                $label1  = 'label-warning';
                $name    = 'Deliver to user';
            }else if($arrVal->types_of_pickup_id == 2){
                $label1  = 'label-primary';
                $name    = 'User pickup';
            }

            if($arrVal->status_id == 16 || $arrVal->status_id == 2){
              $label = 'label-warning';
            }else if($arrVal->status_id == 7 || $arrVal->status_id == 12){
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
                      'name'                    => $name,
                      'label1'                  => $label1,
                      'label'                   => $label,
                      'status_name'             => $arrVal->status_name);
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
      return view('terminate.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status_id'  => 'required',
        ]);

        DB::beginTransaction();
        try {

          $return = ReturnBoxes::find($id);
          if (empty($return)) {
            throw new Exception('Edit Data Return Boxes failed.[ER-01]');
          }

          $now_date = Carbon::now();
          $execution_date = Carbon::parse($return->date);
          if ($now_date->lt($execution_date)) {
            throw new Exception("Edit Data Return Boxes failed, Tanggal tidak sesuai.");
          }

          // sudah finished
          if ($return->status_id == 28) {
            throw new Exception("Edit Data Return Boxes failed, Sudah Terminated.");
          }

          $return->status_id    = $request->status_id;
          if ($request->status_id == 2) {
            $return->driver_name  = $request->driver_name;
            $return->driver_phone = $request->driver_phone;
            $return->save();
          } else {
            $return->save();
          }

          $order_detail = OrderDetail::find($request->order_detail_id);
          if (empty($order_detail)) {
            throw new Exception('Edit Data Return Boxes failed.[ER-02]');
          }
          $order_detail->status_id = $request->status_id == 12 ? '28' : $request->status_id;
          if($request->status_id == 4 || $request->status_id == 28){
              $order_detail->place = 'warehouse';
          }
          $order_detail->save();

          //change status box/room to 10 (empty)
          if ($request->status_id == 28){
            //box
            if($order_detail->types_of_box_room_id == 1) {
                $box = Box::find($order_detail->room_or_box_id);
                if (empty($box)) {
                  throw new Exception('Edit Data Return Boxes failed.[Box not Found]');
                }
                $box->status_id = 10;
                $box->save();
            }
            //room
            else if ($order_detail->types_of_box_room_id == 2) {
                $room = SpaceSmall::find($order_detail->room_or_box_id);
                if (empty($room)) {
                  throw new Exception('Edit Data Return Boxes failed.[Room not Found]');
                }
                $room->status_id = 10;
                $room->save();
            }
          }

          $params['status_id']       = $request->status_id;
          $params['order_detail_id'] = $order_detail->id;

          DB::commit();
          
          $order = Order::find($order_detail->order_id);

          if ($request->status_id == 28){
              $order = Order::find($order_detail->order_id);
              $userDevice = UserDevice::where('user_id', $order->user_id)->get();
              if (count($userDevice) > 0){
                //Notif message "Thank you for using Boxin Apps"
                // $response = Requests::post($this->url . 'api/returned/' . $order->user_id, [], $params, []);
                $client = new \GuzzleHttp\Client();
                $response = $client->request('POST', env('APP_NOTIF') . 'api/returned/' . $order->user_id, ['form_params' => [
                  'status_id'       => $request->status_id,
                  'order_detail_id' => $order_detail->id
                ]]);
              }
          }
          
          if(($request->status_id == 16) && $return){  
            $userDevice = UserDevice::where('user_id', $order->user_id)->get();
            if (count($userDevice) > 0){
              $client = new \GuzzleHttp\Client();
              $response = $client->request('POST', env('APP_NOTIF') . 'api/terminate/status/' . $return->id, ['form_params' => [
                'status_id'         => $request->status_id,
                'order_detail_id'   => $order_detail->id
              ]]);
            }
          }

          return redirect()->route('terminate.index')->with('success', 'Edit Data Return Boxes success.');
        } catch (Exception $th) {
          DB::rollback();
          return redirect()->route('terminate.index')->with('error', $th->getMessage());
        }
    }
    
    public function updateDate(Request $request, $id)
    {
      
        $this->validate($request, ['date'  => 'required', 'time'  => 'required']);

        $now_date = Carbon::now();
        $terminate = ReturnBoxes::find($id);
        $terminate->date = date("Y-m-d", strtotime(str_replace('/', '-', $request->date)));
        $terminate->time = $request->time;
        $terminate->save();
          
        return response()->json([
          'message' => 'Edit Date time terminate boxes request success.',
          'data' => $terminate
        ], 200);

    }

    public function destroy($id)
    {

    }
}
