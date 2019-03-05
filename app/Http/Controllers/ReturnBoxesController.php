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

class ReturnBoxesController extends Controller
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
      $data   = $this->repository->all();
      return view('returnbox.index', compact('data'));
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
      return view('returnbox.edit', compact('data', 'id'));
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
          $order_detail->status_id = $request->status_id == 12 ? '18' : $request->status_id;
          $order_detail->save();
          
          //change status box/room to 10 (empty)
          if ($request->status_id == 12){
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
                // $room = Room::find($order_detail->room_or_box_id);
                // if ($room) {
                //   $room->status_id = 10;
                //   $room->save();
                // }
            }
          }

          $params['status_id']       = $request->status_id;
          $params['order_detail_id'] = $order_detail->id;
          if ($request->status_id == 12){
              $order = Order::find($order_detail->order_id);
              $userDevice = UserDevice::where('user_id', $order->user_id)->get();
              if (count($userDevice) > 0){
                //Notif message "Thank you for using Boxin Apps"
                $response = Requests::post($this->url . 'api/returned/' . $order->user_id, [], $params, []);
              }
          }

          DB::commit();
          return redirect()->route('return.index')->with('success', 'Edit Data Return Boxes success.');
        } catch (Exception $th) {
          DB::rollback();
          return redirect()->route('return.index')->with('error', $th->getMessage());
          return redirect()->route('return.index')->with('error', 'Edit Data Return Boxes failed.');
        }

        

        // if($return){
        //     $order_detail            = OrderDetail::find($request->order_detail_id);
        //     $order_detail->status_id = $request->status_id == '12' ? '18' : $request->status_id;
        //     $order_detail->save();

        //     //change status box/room to 10 (empty)
        //     if($request->status_id == '12'){
        //         //box
        //         if($order_detail->types_of_box_room_id == 1) {
        //             $box = Box::find($order_detail->room_or_box_id);
        //             $box->status_id = 10;
        //             $box->save();
        //         }
        //         //room
        //         else if ($order_detail->types_of_box_room_id == 2) {
        //             $room = Room::find($order_detail->room_or_box_id);
        //             $room->status_id = 10;
        //             $room->save();
        //         }
        //     }

        //     $params['status_id'] =  $request->status_id;
        //     $params['order_detail_id'] =  $order_detail->id;
        //     if($request->status_id == 12){

        //         $order = Order::find($order_detail->order_id);
        //         $userDevice = UserDevice::where('user_id', $order->user_id)->get();
        //         if(count($userDevice) > 0){
        //             //Notif message "Thank you for using Boxin Apps"
        //     		$response = Requests::post($this->url . 'api/returned/' . $order->user_id, [], $params, []);
        //         }
        //     }

        //     return redirect()->route('return.index')->with('success', 'Edit Data Return Boxes success.');
        // } else {
        //     return redirect()->route('return.index')->with('error', 'Edit Data Return Boxes failed.');
        // }
    }

    public function destroy($id)
    {

    }
}
