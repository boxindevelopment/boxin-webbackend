<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Area;
use App\Model\SpaceSmall;
use App\Model\Shelves;
use App\Model\TypeSize;
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
      $data = $this->repository->all();
      return view('space_smalls.index', compact('data'));
    }

    public function create()
    {
      $type_size = TypeSize::where('types_of_box_room_id', 2)->orderBy('id')->get();
      return view('space_smalls.create', compact('type_size'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'shelves_id'     => 'required',
            'type_size_id'  => 'required',
            'count_space'     => 'required',
            'code_space_small'     => 'required',
        ]);

        $type_size = TypeSize::where('id', $request->type_size_id)->first();
        $name = $request->name;
        if($name == ''){
            $name = $type_size->name;
        }
        $split              = explode('##', $request->shelves_id);
        $shelves_id         = $split[0];
        $code_shelves       = $split[1];

        for($i=0; $i<$request->count_space;$i++){
            $no = $i+1;
            if($request->count_space == 1){
                $name_space = $name;
            }else{
                $name_space = $name.' '.$no;
            }

            // $sql        = SpaceSmall::where('shelves_id', '=', $shelves_id)->where('deleted_at', NULL)->orderBy('code_space_small', 'desc')->first();
            // $id_number  = isset($sql->code_space_small) ? substr($sql->code_space_small, 9) : 0;
            // $code       = str_pad($id_number + 1, 3, "0", STR_PAD_LEFT);

            $spaceSmall = SpaceSmall::create([
                'types_of_size_id'  => $request->type_size_id,
                'shelves_id'        => $shelves_id,
                'name'              => $name_space,
                'location'          => $request->location,
                'code_space_small'  => $request->code_space_small,
                'barcode'           => $request->code_space_small,
                'status_id'         => 10,
            ]);
            $spaceSmall->save();
        }
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

        $space  = $this->repository->find($id);
        $name   = $space->name;
        $space->deleted_at = Carbon\Carbon::now();
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
        $sql     = SpaceSmall::where('shelves_id', '=', $request->input('shelves_id'))
                  ->where('deleted_at', NULL)
                  ->orderBy('code_space_small', 'desc')
                  ->first();
        $id_number = isset($sql->code_space_small) ? substr($sql->code_space_small, 4) : 0;
        $code      = str_pad($id_number + 1, 2, "0", STR_PAD_LEFT);

        return $code;
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
