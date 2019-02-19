<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Shelves;
use App\Model\Space;
use App\Model\Box;
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
      $data      = $this->repository->all();
      return view('shelves.index', compact('data'));
    }

    public function create()
    {
      return view('shelves.create');
    }

    public function store(Request $request)
    {

      $shelves = Shelves::create([
        'name'           => $request->name,
        'area_id'        => $request->area_id,
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
      $split          = explode('##', $request->space_id);
      $space_id       = $split[0];

      $shelves            = $this->repository->find($id);
      $shelves->name      = $request->name;
      if($shelves->space_id != $space_id){
        $shelves->space_id  = $space_id;
        $shelves->id_name   = $request->id_name_shelf;
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
      for ($a = 0; $a < $count_box ; $a++) {
        $box = Box::find($box_[$a]->id);
        $box->deleted_at = Carbon\Carbon::now();
        $box->save();
      }

      $shelves  = $this->repository->find($id);
      $name     = $shelves->name;
      $shelves->deleted_at = Carbon\Carbon::now();
      $shelves->save();

      $space = Space::find($shelves->space_id);
      $space->status_id = 10;
      $space->save();

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

    public function getNumber(Request $request)
    {
        $sql          = Shelves::where('area_id', '=', $request->input('area_id'))
                        ->where('deleted_at', NULL)
                        ->orderBy('code_shelves', 'desc')
                        ->first();
        $code_shelves    = isset($sql->code_shelves) ? substr($sql->code_shelves, 4) : 0;
        $code         = str_pad($code_shelves + 1, 2, "0", STR_PAD_LEFT);

        return $code;
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

}
