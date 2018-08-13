<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Area;
use App\Model\City;
use App\Model\Warehouse;
use Carbon;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $area   = Area::where('deleted_at', NULL)->orderBy('name')->get();
      $cities = City::where('deleted_at', NULL)->orderBy('name')->get();
      return view('warehouses.list_area', compact('area','cities'));
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
      $this->validate($request,[
        'name' => 'required|max:255',
      ]);

      $city_id = $request->city_id;
      $name    = $request->name;

      $area = Area::create([
        'name'              => $name,
        'city_id'           => $city_id,
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
      $area   = Area::find($id);
      $cities = City::where('deleted_at', NULL)->orderBy('name')->get();
      return view('warehouses.edit_area', compact('area', 'id', 'cities'));
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
      $area       = Area::find($id);
      $area->name = $request->name;
      $area->city_id = $request->city_id;
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

      $area = Area::find($id);
      $name = $area->name;
      $area->deleted_at = Carbon\Carbon::now();
      $area->save();

      if($area){
        return redirect()->route('warehouses-area.index')->with('success', 'Warehouse Area ['.$name.'] deleted.');
      } else {
        return redirect()->route('warehouses-area.index')->with('error', 'Delete Warehouse Area failed.');
      }
      
    }
}
