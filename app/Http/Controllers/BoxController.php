<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Box;
use App\Model\Space;
use App\Model\Shelves;
use App\Model\TypeSize;
use Carbon;
use App\Repositories\BoxRepository;
use PDF;

class BoxController extends Controller
{
    protected $repository;

    public function __construct(BoxRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return view('boxes.index');
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

        $boxes = $this->repository->getData($args);

        $recordsTotal = count($boxes);

        $recordsFiltered = $this->repository->getCount($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($boxes as $arrVal) {
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
                      'status_name' => $arrVal['status_name']);
                $arr_data['data'][] = $arr;

            }

            $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
    }

    public function create()
    {
        $type_size = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();
        return view('boxes.create', compact('type_size'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'shelves_id'  => 'required',
            'type_size_id' => 'required',
            'code_box' => 'required',
        ]);

        $box = Box::where('code_box', $request->input('code_box'))
             ->where('deleted_at', NULL)
             ->first();

        if($box){
            return redirect()->route('box.index')->with('error', 'Add New Box failed (code is used).');
        }

        $type_size = TypeSize::where('id', $request->type_size_id)->first();
        $name = $request->name;
        if($name == ''){
            $name = $type_size->name;
        }

        $split        = explode('##', $request->shelves_id);
        $shelves_id   = $split[0];
        $box = Box::create([
                    'types_of_size_id'  => $request->type_size_id,
                    'shelves_id'        => $shelves_id,
                    'name'              => $name,
                    'location'          => $request->location,
                    'barcode'           => $request->code_box,
                    'code_box'          => $request->code_box,
                    'status_id'         => 10,
                ]);

        if($box){
            return redirect()->route('box.index')->with('success', 'Add : [' . $name . '] success.');
        } else {
            return redirect()->route('box.index')->with('error', 'Add New Box failed.');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
      $box       = $this->repository->getEdit($id);
      $type_size = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();
      $edit_box  = true;
      return view('boxes.edit', compact('id', 'box', 'type_size', 'edit_box'));
    }

    public function update(Request $request, $id)
    {
      $split      = explode('##', $request->shelves_id);
      $shelves_id = $split[0];
      $box                    = $this->repository->find($id);
      $box->name              = $request->name;
      $box->types_of_size_id  = $request->type_size_id;
      $box->location          = $request->location;
      if($box->shelves_id != $shelves_id){
        $box->shelves_id      = $shelves_id;
      }
      if($request->code_box != ''){
        $box->id_name         = $request->code_box;
        $box->barcode         = $request->code_box;
        $box->code_box         = $request->code_box;
      }
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Edit ['.$request->name.'] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Edit Box failed.');
      }
    }

    public function destroy($id)
    {
        $orderDetail = OrderDetail::where('room_or_box_id', $id)->where('types_of_box_room_id', 1)->first();
        if($orderDetail){
            return redirect()->route('box.index')->with('error', "Can't delete boxes, the boxes has a relation to the order");
        }
      $box  = $this->repository->find($id);
      $name = $box->name;
      $box->deleted_at = Carbon\Carbon::now();
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Delete ['.$name.'] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Edit Box failed.');
      }
    }

    public  function printBarcode($id)
    {
      $produk  = $this->repository->getById($id);
      $no = 1;
      $pdf =  PDF::loadView('boxes.barcode'  ,  compact('produk','no'));
      $pdf->setPaper('a7',  'landscape');
      return $pdf->stream();
    }

    public function get_code_box($code_shelves, $codes){

        $code_box_array = ['B1010101', 'B1010102', 'B1010103', 'B1010201', 'B1010202', 'B1010203', 'B1010301', 'B1010302', 'B1010303',
                           'B1020101', 'B1020102', 'B1020103', 'B1020201', 'B1020202', 'B1020203', 'B1020301', 'B1020302', 'B1020303',
                           'B2010101', 'B2010102', 'B2010103', 'B2010201', 'B2010202', 'B2010203', 'B2010301', 'B2010302', 'B2010303',
                           'B2020101', 'B2020102', 'B2020103', 'B2020201', 'B2020202', 'B2020203', 'B2020301', 'B2020302', 'B2020303'];
        $code_boxes = [];
        foreach ($code_box_array as $box) {
            if(!in_array($box, $codes)){
                $code_boxes[] = $code_shelves . $box;
            }
        }
        return $code_boxes;

    }

    public function getCodeUsed(Request $request)
    {

        $get_ccode     = Box::select('code_box')
                            ->where('shelves_id', '=', $request->input('shelves_id'))
                            ->whereRaw("code_box <> '".$request->input('code')."'")
                            ->where('deleted_at', NULL)
                            ->orderBy('code_box', 'asc')
                            ->get();
        $codes = [];
        foreach ($get_ccode as $key => $value) {
            $codes[] = substr($value->code_box, 6);
        }
        $code_boxes = $this->get_code_box($request->code_shelves, $codes);

        echo(json_encode($code_boxes));
    }

    public function getNumber(Request $request)
    {

        $sql     = Box::where('shelves_id', '=', $request->input('shelves_id'))
                  ->where('deleted_at', NULL)
                  ->orderBy('code_box', 'desc')
                  ->first();
        $id_number = isset($sql->code_box) ? substr($sql->code_box, 9) : 0;
        $code      = str_pad($id_number + 1, 3, "0", STR_PAD_LEFT);

        return $code;
    }

    public function checkCode(Request $request)
    {
        $box     = Box::where('code_box', $request->input('code_box'))
                  ->where('deleted_at', NULL)
                  ->first();

        if($box){
            return 'used';
        } else {
            return 'not';
        }
    }

    public function resetNumber(Request $request)
    {
        $boxes    = Box::whereNull('code_box')->get();
        foreach ($boxes as $k => $v) {
            if(!is_null($v->shelves_id)){
                $shelves = Shelves::find($v->shelves_id);
                if($shelves){
                    $shelvesCode = $shelves->code_shelves;
                    $v->code_box = $shelvesCode . 'B1010101';
                    $v->save();
                }
            }
        }

        echo(json_encode($boxes));
    }

}
