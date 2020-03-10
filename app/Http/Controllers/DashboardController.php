<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Repositories\DashboardRepository;
use App\Repositories\SpaceSmallRepository;
use App\Repositories\BoxRepository;
use Carbon;

class DashboardController extends Controller
{
    protected $data;
    protected $space;
    protected $box;

    public function __construct(DashboardRepository $data, SpaceSmallRepository $space, BoxRepository $box)
    {
        $this->data = $data;
        $this->space = $space;
        $this->box = $box;
    }

    public function index(Request $request)
    {
        $user      = $request->user();
        $city      = $this->data->countCity();
        $area      = $this->data->countArea();
        $space     = $this->data->countSpace();
        $available_space = $this->data->countSpaceAvailable();
        $box       = $this->data->countBox();
        $shelves   = $this->data->countShelves();
        $available_box      = $this->data->countBoxAvailable();
        $totalSales         = $this->data->totalSales();
        $totalSalesMonth    = $this->data->totalSalesMonth();
        $me                 = Auth::id();
        return view('dashboard', compact('city', 'space', 'box', 'area', 'me', 'available_space', 'available_box', 'shelves', 'totalSales', 'totalSalesMonth'));
    }

    public function graphicOrder()
    {
        $chartData = $this->data->getGraphicOrder();
        $chartDatas = $chartData->get()->toArray();

        $chartDataByDay = array();
        foreach($chartDatas as $data) {
             $chartDataByDay[date("Y-m", mktime(0, 0, 0, $data['Month'], 1,$data['Year']))] = $data['TotalAmount'];
        }

        $date = new Carbon\Carbon;
        for($i = 0; $i < 12; $i++) {
            $dateString = $date->format('Y-m');
            if(!isset($chartDataByDay[ $dateString ])) {
                $chartDataByDay[ $dateString ] = 0;
            }
            $date->subMonth();
        }

        ksort($chartDataByDay);
        echo (json_encode($chartDataByDay));
    }

    public function space()
    {
      return view('dashboard.space_small');
    }


    public function getAjaxSpace(Request $request)
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

        $smallSpace = $this->space->getDataSpace($args);

        $recordsTotal = count($smallSpace);

        $recordsFiltered = $this->space->getCountSpace($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($smallSpace as $arrVal) {
            $no++;
            $arr = array(
                      'no' => $no,
                      'id' => $arrVal['id'],
                      'code_space_small' => $arrVal['code_space_small'],
                      'name' => $arrVal['name'],
                      'type_size_name' => $arrVal['type_size_name'],
                      'type_size_size' => $arrVal['size'], //
                      'shelves_name' => $arrVal['shelves_name'], //
                      'location' => $arrVal['location'], //
                      'id_name' => $arrVal['transaction'] ? $arrVal['transaction']['id_name'] : null, //
                      'status_name' => $arrVal['status_name']);
                $arr_data['data'][] = $arr;

            }

            $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
    }

    public function box()
    {
      return view('dashboard.box');
    }
    public function getAjaxBox(Request $request)
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

        $boxs = $this->box->getDataBox($args);

        $recordsTotal = count($boxs);

        $recordsFiltered = $this->box->getCountBox($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($boxs as $arrVal) {
            $no++;
            $arr = array(
                      'no' => $no,
                      'id' => $arrVal['id'],
                      'code_box' => $arrVal['code_box'],
                      'name' => $arrVal['name'],
                      'type_size_name' => $arrVal['type_size_name'],
                      'type_size_size' => $arrVal['size'], //
                      'shelves_name' => $arrVal['shelves_name'], //
                      'location' => $arrVal['location'], //
                      'id_name' => $arrVal['transaction'] ? $arrVal['transaction']['id_name'] : null, //
                      'status_name' => $arrVal['status_name']);
                $arr_data['data'][] = $arr;

            }

            $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
    }

}
