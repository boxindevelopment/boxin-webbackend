<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Area;
use App\Model\SpaceSmall;
use App\Model\Shelves;
use App\Model\TypeSize;
use App\Model\OrderDetail;
use Carbon;
use App\Repositories\SpaceSmallRepository;
use PDF;

class SpaceSmallController extends Controller
{
    protected $repository;

    public function __construct(SpaceSmallRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      return view('space_smalls.index');
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

        $smallSpace = $this->repository->getData($args);

        $recordsTotal = count($smallSpace);

        $recordsFiltered = $this->repository->getCount($args);

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
                      'area_name' => $arrVal['area_name'], //
                      'status_name' => $arrVal['status_name']);
                $arr_data['data'][] = $arr;

            }

            $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
    }

    public function create()
    {
      $type_size = TypeSize::where('types_of_box_room_id', 2)->orderBy('id')->get();
      return view('space_smalls.create', compact('type_size'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'shelves_id'        => 'required',
            'type_size_id'      => 'required',
            'code_space_small'  => 'required',
        ]);

        $type_size = TypeSize::where('id', $request->type_size_id)->first();
        $name = $request->name;
        if($name == ''){
            $name = $type_size->name;
        }
        $split                  = explode('##', $request->shelves_id);
        $shelves_id             = $split[0];
        $code_shelves           = $split[1];

        $spaceSmall = SpaceSmall::create([
            'types_of_size_id'  => $request->type_size_id,
            'shelves_id'        => $shelves_id,
            'name'              => $name,
            'location'          => $request->location,
            'code_space_small'  => $request->code_space_small,
            'barcode'           => $request->code_space_small,
            'status_id'         => 10,
        ]);

        if($spaceSmall){
            return redirect()->route('space.index')->with('success', 'Add : [' . $name . '] success.');
        } else {
            return redirect()->route('space.index')->with('error', 'Add New Space Small failed.');
        }

    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $space      = $this->repository->getEdit($id);
      $type_size  = TypeSize::where('types_of_box_room_id', 2)->orderBy('id')->get();
      $edit_space = true;
      return view('space_smalls.edit', compact('id', 'space', 'type_size', 'edit_space'));
    }

    public function update(Request $request, $id)
    {

        $split      = explode('##', $request->shelves_id);
        $shelves_id = $split[0];
        $space                        = $this->repository->find($id);
        $space->name                  = $request->name;
        $space->types_of_size_id      = $request->type_size_id;
        $space->location              = $request->location;

        if($space->shelves_id != $shelves_id){
            $space->shelves_id                  = $shelves_id;
            $space->code_space_small           = $request->code_space_small;
            $space->code_space_small           = $request->code_space_small;
        }
        $space->save();

        if($space){
            return redirect()->route('space.index')->with('success', 'Edit ['.$request->name.'] success.');
        } else {
            return redirect()->route('space.index')->with('error', 'Edit Space Small failed.');
        }
    }

    public function destroy($id)
    {
        $orderDetail = OrderDetail::where('room_or_box_id', $id)->where('types_of_box_room_id', 2)->first();
        if($orderDetail){
            return redirect()->route('space.index')->with('error', "Can't delete space, the space has a relation to the order");
        }
        $space              = $this->repository->find($id);
        $name               = $space->name;
        $space->deleted_at  = Carbon\Carbon::now();
        $space->save();

        if($space){
            return redirect()->route('space.index')->with('success', 'Space small ['.$name.'] deleted.');
        } else {
            return redirect()->route('space.index')->with('error', 'Delete Space Small failed.');
        }
    }

    public function getDataSelectByArea($area_id, Request $request)
    {
        $space    = $this->repository->getSelectByArea($area_id);
        $arrData  = array();
        foreach ($space as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->code_space_small,
                      'text'  =>  $arrVal->name);
            $arrData[] = $arr;
        }
        echo(json_encode($arrData));
    }

    public function getDataSelectAll(Request $request)
    {
        $space    = $this->repository->getSelectAll();
        $arrData  = array();
        foreach ($space as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->code_space_small,
                      'text'  =>  $arrVal->name);
            $arrData[] = $arr;
        }
        echo(json_encode($arrData));
    }

    public function getNumber(Request $request)
    {
        $data_spaces = SpaceSmall::where('shelves_id', '=', $request->input('shelve_id'))
                        ->where('deleted_at', NULL)
                        ->orderBy('code_space_small', 'desc')
                        ->get();

        echo count($data_spaces);
    }

    public  function printBarcode($id)
    {
      $produk  = $this->repository->getById($id);
      $no = 1;
      $pdf =  PDF::loadView('space_smalls.barcode'  ,  compact('produk','no'));
      $pdf->setPaper('a7',  'landscape');
      return $pdf->stream();
    }

    public function resetNumber(Request $request)
    {
        $spaceSmalls    = SpaceSmall::whereNull('code_space_small')->get();
        foreach ($spaceSmalls as $k => $v) {
            if(!is_null($v->shelves_id)){
                $shelves = Shelves::find($v->shelves_id);
                if($shelves){
                    $shelvesCode = $shelves->code_shelves;
                    $v->code_space_small = $shelvesCode . 'S1';
                    $v->save();
                }
            }
        }

        echo(json_encode($spaceSmalls));
    }
}
