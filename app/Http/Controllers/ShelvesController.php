<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Area;
use App\Model\Shelves;
use App\Model\Space;
use App\Model\SpaceSmall;
use App\Model\Box;
use App\Model\OrderDetail;
use Carbon;
use App\Repositories\ShelvesRepository;

class ShelvesController extends Controller
{
    protected $repository;

    public function __construct(ShelvesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      return view('shelves.index');
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

        $shelves = $this->repository->getData($args);

        $recordsTotal = count($shelves);

        $recordsFiltered = $this->repository->getCount($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($shelves as $arrVal) {
            $no++;
            $arr = array(
                      'no' => $no,
                      'id' => $arrVal['id'],
                      'code_shelves' => $arrVal['code_shelves'],
                      'name' => $arrVal['name'],
                      'count_box' => $arrVal['count_box'],
                      'area_name' => $arrVal['area_name']);
                $arr_data['data'][] = $arr;

            }

            $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
    }

    public function create()
    {
      return view('shelves.create');
    }

    public function store(Request $request)
    {
      $area_id =  explode('##', $request->area_id)[0];
      $shelves = Shelves::create([
        'name'           => $request->name,
        'area_id'        => $area_id,
        'code_shelves'   => $request->code_shelves,
      ]);

      if($shelves){
        return redirect()->route('shelves.index')->with('success', 'Shelf ['.$request->name.'] added.');
      } else {
        return redirect()->route('shelves.index')->with('error', 'Add New Shelf failed.');
      }
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $shelves      = $this->repository->getEdit($id);
      $edit_shelves = true;
      return view('shelves.edit', compact('shelves', 'id', 'edit_shelves'));
    }

    public function update(Request $request, $id)
    {

      $split          = explode('##', $request->area_id);
      $area_id       = $split[0];

      $shelves            = $this->repository->find($id);
      $shelves->name      = $request->name;
      if($shelves->area_id != $area_id){
        $shelves->area_id  = $area_id;
        $shelves->code_shelves   = $request->code_shelves;
      }
      $shelves->save();

      if($shelves){
        return redirect()->route('shelves.index')->with('success', 'Shelf ['.$request->name.'] edited.');
      } else {
        return redirect()->route('shelves.index')->with('error', 'Edit Shelf failed.');
      }
    }

    public function destroy($id)
    {
      $box_         = Box::where('shelves_id', $id)->get();
      $count_box    = count($box_);
      if($count_box > 0){
        $box_pluck = $box_->pluck('id');
        $orderDetail = OrderDetail::whereIn('room_or_box_id', $box_pluck)->where('types_of_box_room_id', 1)->get();
        if($orderDetail){
            return redirect()->route('box.index')->with('error', "Can't delete shelves, the boxes has a relation to the order");
        }
        for ($a = 0; $a < $count_box ; $a++) {
          $box = Box::find($box_[$a]->id);
          $box->deleted_at = Carbon\Carbon::now();
          $box->save();
        }
      }
      $space_small_         = SpaceSmall::where('shelves_id', $id)->get();
      $count_space_small    = count($space_small_);
      if($count_space_small > 0){
        $space_small_pluck = $space_small_->pluck('id');
        $orderDetail2 = OrderDetail::whereIn('room_or_box_id', $space_small_pluck)->where('types_of_box_room_id', 2)->get();
        if($orderDetail2){
            return redirect()->route('box.index')->with('error', "Can't delete shelves, the space has a relation to the order");
        }
        for ($a = 0; $a < $count_space_small ; $a++) {
          $space_small = SpaceSmall::find($space_small_[$a]->id);
          $space_small->deleted_at = Carbon\Carbon::now();
          $space_small->save();
        }
      }

      $shelves  = $this->repository->find($id);
      $name     = $shelves->name;
      $shelves->deleted_at = Carbon\Carbon::now();
      $shelves->save();

      // $space = Space::find($shelves->space_id);
      // $space->status_id = 10;
      // $space->save();

      if($shelves){
        return redirect()->route('shelves.index')->with('success', 'Shelf ['.$name.'] deleted.');
      } else {
        return redirect()->route('shelves.index')->with('error', 'Delete Shelf failed.');
      }
    }

    public function getDataSelectBySpace($space_id, Request $request)
    {
        $data = $this->repository->getSelectBySpace($space_id);
        $arrData = array();
        foreach ($data as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->id_name,
                      'text'  =>  $arrVal->name);
            $arrData[] = $arr;
        }
        echo(json_encode($arrData));
    }

    public function getDataSelectByArea($area_id, Request $request)
    {
        $data = $this->repository->getSelectByArea($area_id);
        $arrData = array();
        foreach ($data as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->code_shelves,
                      'text'  =>  $arrVal->name);
            $arrData[] = $arr;
        }
        echo(json_encode($arrData));
    }

    public function getDataSelectAll(Request $request)
    {
        $data = $this->repository->getSelectAll();
        $arrData = array();
        foreach ($data as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->code_shelves,
                      'text'  =>  $arrVal->name);
            $arrData[] = $arr;
        }
        echo(json_encode($arrData));
    }

    public function resetNumber(Request $request)
    {
        $shelveses    = Shelves::whereNull('code_shelves')->get();
        foreach ($shelveses as $k => $v) {
            if(!is_null($v->space_id)){
                $space = Space::with('area')->find($v->space_id);
                if($space){
                    $areaCode = $space->area->id_name;
                    $lengthCode = strlen($space->id_name);
                    $subCode = substr($v->id_name, $lengthCode);
                    $v->code_shelves = $areaCode . $subCode;
                    $v->save();
                }
            }
        }

        echo(json_encode($shelveses));
    }

    public function getNumber(Request $request)
    {
        $rArea        = Area::find($request->input('area_id'));
        $sql          = Shelves::where('area_id', '=', $request->input('area_id'))
                        ->where('deleted_at', NULL)
                        ->orderBy('id', 'desc')
                        ->first();
        $code_shelves    = isset($sql->code_shelves) ? substr($sql->code_shelves, 4) : 'A';
        $code_number     =  ($code_shelves != 'A' ) ? $this->getColNo($code_shelves)+1 : $this->getColNo($code_shelves);
        $code            =  $this->getNameFromNumber($code_number);

        return $code;
    }

    private function getNameFromNumber($num) {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return $this->getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }

    private function getColNo($colLetters){

        $limit = 5; //apply max no. of characters
        $colLetters = strtoupper($colLetters); //change to uppercase for easy char to integer conversion
        $strlen = strlen($colLetters); //get length of col string

        if($strlen > $limit)return "Column too long!"; //may catch out multibyte chars in first pass
        preg_match("/^[A-Z]+$/",$colLetters,$matches); //check valid chars

        if(!$matches)return "Invalid characters!"; //should catch any remaining multibyte chars or empty string, numbers, symbols

        $it = 0; $vals = 0; //just start off the vars
        for($i=$strlen-1;$i>-1;$i--){ //countdown - add values from righthand side
            $vals += (ord($colLetters[$i]) - 64 ) * pow(26,$it); //cumulate letter value
            $it++; //simple counter
        }
        return $vals - 1; //this is the answer

    }

}
