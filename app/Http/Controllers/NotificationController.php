<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;

class NotificationController extends Controller
{
    protected $repository;


    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $countUnRead = $this->repository->getCountUnRead();
        return view('notification.index', compact('countUnRead'));
    }

    public function getAjaxNotif(Request $request)
    {
        $countUnRead    = $this->repository->getCountUnRead();
        $data           = $this->repository->getDataLimit(10);
        return response()->json([
            'status' => true,
            'data' => $data,
            'count' => $countUnRead
        ]);
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
        $args['orderColumns'] = ($columns[$orderNumber]['name']) ? $columns[$orderNumber]['name'] : 'title';

        $returnBoxes = $this->repository->getData($args);

        $recordsTotal = count($returnBoxes);

        $recordsFiltered = $this->repository->getCount($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($returnBoxes as $arrVal) {
            $no++;

            $arr = array(
                      'no'                      => $no,
                      'id'                      => $arrVal->id,
                      'type'                    => $arrVal->type,
                      'notifiable_type'         => $arrVal->notifiable_type,
                      'created_at'              => date("d-m-Y H:s:i", strtotime($arrVal->created_at)),
                      'read_at'                 => ($arrVal->read_at) ? date("d-m-Y H:s:i", strtotime($arrVal->read_at)) : '-',
                      'user_fullname'           => $arrVal->first_name . ' ' . $arrVal->last_name,
                      'user_id'                 => $arrVal->user_id,
                      'title'                   => $arrVal->title,
                      'user_id'                 => $arrVal->user_id,
                      'data'                    => $arrVal->data);
                $arr_data['data'][] = $arr;

        }

        $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
    }
}
