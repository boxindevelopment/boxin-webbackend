<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Area;
use App\Model\Space;
use App\Model\Shelves;
use App\Model\TypeSize;
use Carbon;
use App\Repositories\SpaceRepository;

class SpaceController extends Controller
{
    protected $repository;

    public function __construct(SpaceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $data = $this->repository->all();
      return view('spaces.index', compact('data'));
    }

    public function create()
    {
      $type_size = TypeSize::where('types_of_box_room_id', 2)->orderBy('id')->get();
      return view('spaces.create', compact('type_size'));
    }

    public function store(Request $request)
    {
      $type_size = TypeSize::where('id', $request->type_size_id)->first();
      $name = $request->name;
      if($name == ''){
        $name = $type_size->name;
      }

      $split    = explode('##', $request->area_id);
      $area_id  = $split[0];

      $id_name_space = intval($request->id_name_space);

      for($i=0; $i<$request->count_space;$i++){
      
        if(strlen($id_name_space) < 6){
          $name_space_id = '0'.$id_name_space;
        }else{
          $name_space_id = $id_name_space;
        }

        $no = $i+1;
        if($request->count_space == 1){
          $name_space = $name;
        }else{
          $name_space = $name.' '.$no;
        }
        $space = Space::create([
          'name'      => $name_space,
          'area_id'   => $area_id,
          'long'      => $request->longitude,
          'lat'       => $request->latitude,
          'id_name'   => $name_space_id,
          'types_of_size_id'  => $request->type_size_id,          
          'status_id' => 10,
        ]);
        $space->save();
        $id_name_space += 1;
      }   

      if($space){
        return redirect()->route('space.index')->with('success', 'New Space ['.$request->name.'] added.');
      } else {
        return redirect()->route('space.index')->with('error', 'Add New Space failed.');
      }
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $space      = $this->repository->getEdit($id);   
      $type_size  = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();   
      $edit_space = true;
      return view('spaces.edit', compact('id', 'space', 'type_size', 'edit_space'));
    }

    public function update(Request $request, $id)
    {
      $split    = explode('##', $request->area_id);
      $area_id  = $split[0];

      $space                    = $this->repository->find($id);
      $space->name              = $request->name;
      $space->long              = $request->longitude;
      $space->lat               = $request->latitude;
      $space->types_of_size_id  = $request->type_size_id;
      if($space->area_id != $area_id){
        $space->area_id   = $area_id;   
        $space->id_name   = $request->id_name_space;
      }        
      $space->save();

      if($space){
        return redirect()->route('space.index')->with('success', 'Space ['.$request->name.'] edited.');
      } else {
        return redirect()->route('space.index')->with('error', 'Edit Space failed.');
      }
    }

    public function destroy($id)
    {
      $shelves_       = Shelves::where('space_id', $id)->get();
      $count_shelves  = count($shelves_);
      for ($i = 0; $i < $count_shelves ; $i++) {
        $shelves = Shelves::find($shelves_[$i]->id);
        $shelves->deleted_at = Carbon\Carbon::now();
        $shelves->save();
      }

      $space  = $this->repository->find($id);
      $name   = $space->name;
      $space->deleted_at = Carbon\Carbon::now();
      $space->save();

      if($space){
        return redirect()->route('space.index')->with('success', 'Space ['.$name.'] deleted.');
      } else {
        return redirect()->route('space.index')->with('error', 'Delete Space failed.');
      }
    }

    public function getDataSelectByArea($area_id, Request $request)
    {
        $space    = $this->repository->getSelectByArea($area_id);
        $arrData  = array();
        foreach ($space as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->id_name,
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
                      'id'    => $arrVal->id . '##' . $arrVal->id_name,
                      'text'  =>  $arrVal->name);
            $arrData[] = $arr;
        }
        echo(json_encode($arrData));
    }

    public function getNumber(Request $request)
    {
        $sql     = Space::where('area_id', '=', $request->input('area_id'))
                  ->where('deleted_at', NULL)
                  ->orderBy('id_name', 'desc')
                  ->first();
        $id_number = isset($sql->id_name) ? substr($sql->id_name, 4) : 0;
        $code      = str_pad($id_number + 1, 2, "0", STR_PAD_LEFT);

        return $code;
    }
}
