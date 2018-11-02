<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Area;
use App\Model\City;
use App\Model\Warehouse;
use Carbon;
use App\Repositories\AreaRepository;
use DB;

class AreaController extends Controller
{
    protected $area;

    public function __construct(AreaRepository $area)
    {
        $this->area = $area;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $area   = $this->area->all();
      return view('warehouses.list_area', compact('area'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      abort('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $split    = explode('##', $request->city_id);
      $city_id  = $split[0];

      $area = Area::create([
        'name'      => $request->name,
        'city_id'   => $city_id,
        'id_name'   => $request->id_name_area,
      ]);

      if($area){
        return redirect()->route('warehouses-area.index')->with('success', 'Warehouse Area ['.$request->name.'] added.');
      } else {
        return redirect()->route('warehouses-area.index')->with('error', 'Add New Warehouse Area failed.');
      }      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $area   = $this->area->find($id);
      return view('warehouses.edit_area', compact('area', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $split    = explode('##', $request->city_id);
      $city_id  = $split[0];

      $area       = $this->area->find($id);
      $area->name = $request->name;
      if($area->city_id != $city_id){
        $area->city_id = $city_id;
        $area->id_name = $request->id_name_area;
      } 
      $area->save();

      if($area){
        return redirect()->route('warehouses-area.index')->with('success', 'Warehouse Area ['.$request->name.'] edited.');
      } else {
        return redirect()->route('warehouses-area.index')->with('error', 'Edit Warehouse Area failed.');
      }

      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $warehouse_       = Warehouse::where('area_id', $id)->get();
      $count_warehouse  = count($warehouse_);
      for ($i = 0; $i < $count_warehouse; $i++) {
        $warehouse = Warehouse::find($warehouse_[$i]->id);
        $warehouse->deleted_at = Carbon\Carbon::now();
        $warehouse->save();
      }

      $area = $this->area->find($id);
      $name = $area->name;
      $area->deleted_at = Carbon\Carbon::now();
      $area->save();

      if($area){
        return redirect()->route('warehouses-area.index')->with('success', 'Warehouse Area ['.$name.'] deleted.');
      } else {
        return redirect()->route('warehouses-area.index')->with('error', 'Delete Warehouse Area failed.');
      }
      
    }

    public function getDataSelectByCity($city_id, Request $request)
    {

        $areas = $this->area->getSelect($city_id);
        $arrAreas = array();
        foreach ($areas as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->id_name,
                      'text'  =>  $arrVal->name);
            $arrAreas[] = $arr;
        }
        echo(json_encode($arrAreas));

    }

    public function getDataSelectAll(Request $request)
    {

        $areas = $this->area->getSelectAll();
        $arrAreas = array();
        foreach ($areas as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->id_name,
                      'text'  =>  $arrVal->name);
            $arrAreas[] = $arr;
        }
        echo(json_encode($arrAreas));

    }

    public function getNumber(Request $request)
    {

        $city_id = $request->input('city_id');
        $sql     = Area::where('city_id', '=', $city_id)
        ->orderBy('id_name', 'desc')
        ->first();
        $id_number   = isset($sql->id_name) ? substr($sql->id_name, 2) : 0;
        $code        = str_pad($id_number + 1, 2, "0", STR_PAD_LEFT);

        return $code;

    }

}
