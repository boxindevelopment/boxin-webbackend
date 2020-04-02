<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PickupOrder;
use App\Model\Order;
use App\Model\OrderDetail;
use DB;
use Carbon\Carbon;
use App\Repositories\PickupOrderRepository;
use Requests;
use App\Model\UserDevice;
use Exception;

class PickupController extends Controller
{
    protected $repository;

	private $url;
	CONST DEV_URL = 'https://boxin-dev-notification.azurewebsites.net/';
	CONST LOC_URL = 'http://localhost:5252/';
	CONST PROD_URL = 'https://boxin-prod-notification.azurewebsites.net/';

    public function __construct(PickupOrderRepository $repository)
    {
        $this->url        = (env('DB_DATABASE') == 'coredatabase') ? self::DEV_URL : self::PROD_URL;
        $this->repository = $repository;
    }

    public function index()
    {
      return view('pickup.index');
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

        $pickup = $this->repository->getData($args);

        $recordsTotal = count($pickup);

        $recordsFiltered = $this->repository->getCount($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($pickup as $arrVal) {
            $no++;
            if($arrVal['types_of_pickup_id'] == 1){
                $label1  = 'label-warning';
                $name1   = 'Deliver to user';
            }else if($arrVal['types_of_pickup_id'] == 2){
                $label1  = 'label-primary';
                $name1   = 'User pickup';
            }else if($arrVal['types_of_pickup_id'] == 24){
                $label1  = 'label-warning';
                $name1   = 'User Cancelled';
            } else {
                $label1  = 'label-warning';
                $name1   = '';
            }

            if($arrVal['status_id'] == 11 || $arrVal['status_id'] == 14 || $arrVal['status_id'] == 15 || $arrVal['status_id'] == 8 || $arrVal['status_id'] == 6){
              $label = 'label-danger';
            } else if($arrVal['status_id'] == 12){
              $label = 'label-inverse';
            } else if($arrVal['status_id'] == 7 || $arrVal['status_id'] == 5){
              $label = 'label-success';
          } else if($arrVal['status_id'] == 2){
              $label = 'label-warning';
            } else {
                $label = 'label-warning';
            }

            $arr = array(
                      'no' => $no,
                      'id' => $arrVal['id'],
                      'date' => date("d-m-Y", strtotime($arrVal['date'])),
                      'id_name' => $arrVal['id_name'],
                      'user_fullname' => $arrVal['first_name'] . ' ' . $arrVal['last_name'],
                      'place' => 'warehouse',
                      'status_id' => $arrVal['status_id'],
                      'status_name' => $arrVal['status_name'],
                      'types_of_pickup_name' => $arrVal['types_of_pickup_name'],
                      'label1' => $label1,
                      'name1' => $name1,
                      'label' => $label);
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
      $pickup     = PickupOrder::select('pickup_orders.*')->where('id',$id)->get();
      return view('pickup.edit', compact('pickup', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, ['status_id'  => 'required']);

        $order_id = $request->order_id;
        $status   = $request->status_id;

        $stored_status = $status;
        if ($status == 12) {
          $stored_status = 4;
        }

        $now_date = Carbon::now();
        $pickup = PickupOrder::find($id);
        $execution_date = Carbon::parse($pickup->date);
        if ($now_date->lt($execution_date)) {
          return redirect()->route('pickup.index')->with('error', 'Edit Data Pickup Order failed, Tanggal tidak sesuai.');
        }

        $starts_date = null;
        if ($pickup) {
          $starts_date = $execution_date->toDateString();
        } else {
          $starts_date = Carbon::now()->toDateString();
        }

        DB::beginTransaction();
        try {

          $order            = Order::find($order_id);
          $order->status_id = $stored_status;
          $order->save();
          $users_id = $order->user_id;

          $order_details = OrderDetail::where('order_id', '=', $order_id)->get();
          foreach ($order_details as $key => $order_detail) {
            $order_detail->status_id = $stored_status;
            // jika sudah finished (12) atau ondeliver (2)
            if ($status == 12 || $status == 2) {
                $new_end_date = null;
                $order_detail->start_date = $starts_date;
                // daily
                if ($order_detail->types_of_duration_id == 1 || $order_detail->types_of_duration_id == '1') {
                    $new_end_date = date('Y-m-d', strtotime('+'.$order_detail->duration.' days', strtotime($starts_date)));
                }
                // weekly
                else if ($order_detail->types_of_duration_id == 2 || $order_detail->types_of_duration_id == '2') {
                    $end_date               = $order_detail->duration * 7;
                    $new_end_date = date('Y-m-d', strtotime('+'.$end_date.' days', strtotime($starts_date)));
                }
                // monthly
                else if ($order_detail->types_of_duration_id == 3 || $order_detail->types_of_duration_id == '3') {
                    $new_end_date = date('Y-m-d', strtotime('+'.$order_detail->duration.' month', strtotime($starts_date)));
                }
                // 6month
                else if ($order_detail->types_of_duration_id == 7 || $order_detail->types_of_duration_id == '7') {
                    $end_date               = $order_detail->duration * 6;
                    $new_end_date = date('Y-m-d', strtotime('+'.$end_date.' month', strtotime($starts_date)));
                }
                // annual
                else if ($order_detail->types_of_duration_id == 8 || $order_detail->types_of_duration_id == '8') {
                    $end_date               = $order_detail->duration * 12;
                    $new_end_date = date('Y-m-d', strtotime('+'.$end_date.' month', strtotime($starts_date)));
                }
                $order_detail->end_date = Carbon::parse($new_end_date);
            }
            if($status == 4){
                $order_detail->place    = 'house';
            }
            $order_detail->save();
          }

          if ($status == 4 || $status == 2 || $status == 12) {
              $pickup->status_id    = $status;
              if($status == 2) {
                  $pickup->driver_name  = $request->driver_name;
                  $pickup->driver_phone = $request->driver_phone;
              }
              $pickup->save();
          }

          $params['status_id']       = $status;
          $params['order_detail_id'] = $order_detail->id;
          $userDevice = UserDevice::where('user_id', $users_id)->get();
          if (count($userDevice) > 0){
              switch ($status) {
                case 12:
                  $client = new \GuzzleHttp\Client();
                  $response = $client->request('POST', env('APP_NOTIF') . 'api/item-save/' . $order->user_id, ['form_params' => [
                    'status_id'       => $status
                  ]]);
                  break;

                case 4:
                  $client = new \GuzzleHttp\Client();
                  $response = $client->request('POST', env('APP_NOTIF') . 'api/item-save/' . $order->user_id, ['form_params' => [
                    'status_id'       => $status
                  ]]);
                  break;

                case 2:
                  $client = new \GuzzleHttp\Client();
                  $response = $client->request('POST', env('APP_NOTIF') . 'api/delivery/stored/' . $order->user_id, ['form_params' => [
                    'status_id'       => $status
                  ]]);
                  break;

                default:
                  # code...
                  break;
              }
          }

          DB::commit();
          return redirect()->route('pickup.index')->with('success', 'Edit Data Pickup Order success.');
        } catch (Exception $th) {
          DB::rollback();
          return redirect()->route('pickup.index')->with('error', 'Edit Data Pickup Order failed.');
        }
        // $pickup = PickupOrder::find($id);
        // $starts_date = $pickup->date;

        // $order_details = OrderDetail::where('order_id', '=', $order_id)->get();
        // foreach ($order_details as $key => $order_detail) {
        //     $order_detail->status_id  = $status == '12' ? '4' : $status;
        //     $order_detail->start_date = $pickup->date ? $pickup->date : Carbon::now();
        //     if($order_detail->status_id == '4' || $order_detail->status_id == 4) {
        //         // daily
        //         if ($order_detail->types_of_duration_id == 1 || $order_detail->types_of_duration_id == '1') {
        //             $order_detail->end_date     = date('Y-m-d', strtotime('+'.$order_detail->duration.' days', strtotime($order_detail->start_date)));

        //         }
        //         // weekly
        //         else if ($order_detail->types_of_duration_id == 2 || $order_detail->types_of_duration_id == '2') {
        //             $end_date                   = $order_detail->duration*7;
        //             $order_detail->end_date     = date('Y-m-d', strtotime('+'.$end_date.' days', strtotime($order_detail->start_date)));
        //         }
        //         // monthly
        //         else if ($order_detail->types_of_duration_id == 3 || $order_detail->types_of_duration_id == '3') {
        //             $order_detail->end_date     = date('Y-m-d', strtotime('+'.$order_detail->duration.' month', strtotime($order_detail->start_date)));
        //         }
        //         // 6month
        //         else if ($order_detail->types_of_duration_id == 7 || $order_detail->types_of_duration_id == '7') {
        //             $end_date                   = $order_detail->duration*6;
        //             $order_detail->end_date     = date('Y-m-d', strtotime('+'.$end_date.' month', strtotime($order_detail->start_date)));
        //         }
        //         // annual
        //         else if ($order_detail->types_of_duration_id == 8 || $order_detail->types_of_duration_id == '8') {
        //             $end_date                   = $order_detail->duration*12;
        //             $order_detail->end_date     = date('Y-m-d', strtotime('+'.$end_date.' month', strtotime($order_detail->start_date)));
        //         }
        //     }
        //     $order_detail->save();
        // }

        // $pickup                 = PickupOrder::find($id);
        // $pickup->status_id      = $status;
        // $pickup->driver_name    = $request->driver_name;
        // $pickup->driver_phone   = $request->driver_phone;
        // $pickup->save();

        // if($pickup){
        //     $params['status_id'] =  $status;
        //     $params['order_detail_id'] =  $order_detail->id;
        //     $userDevice = UserDevice::where('user_id', $order->user_id)->get();
        //     if(count($userDevice) > 0){
        //         if($status == 2){
        //             //Notif message "Your items is on the way back to you"
        //     		$response = Requests::post($this->url . 'api/delivery/stored/' . $order->user_id, [], $params, []);
        //         } else if($status == 12){
        //             //Notif message "Congratulation! Your items has been stored"
        //     		$response = Requests::post($this->url . 'api/item-save/' . $order->user_id, [], $params, []);
        //         }
        //     }
        //     return redirect()->route('pickup.index')->with('success', 'Edit Data Pickup Order success.');
        // } else {
        //     return redirect()->route('pickup.index')->with('error', 'Edit Data Pickup Order failed.');
        // }
    }

    public function destroy($id)
    {

    }
}
