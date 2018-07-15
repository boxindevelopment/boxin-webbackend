<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Area;
use App\Entities\Cities;
use App\Entities\Warehouse;

class AreaWarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $area   = Area::where('status', 1)->orderBy('name')->get();
      $cities = Cities::where('status', 1)->orderBy('name')->get();
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
        'city_warehouse_id' => $city_id,
      ]);

      if($area){
        return redirect()->route('warehouses-area.index')->with('success', 'Area Warehouse ['.$request->name.'] added.');
      } else {
        return redirect()->route('warehouses-area.index')->with('error', 'Add New Area Warehouse failed.');
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
      $cities = Cities::where('status', 1)->orderBy('name')->get();
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
      $area->city_warehouse_id = $request->city_id;
      $area->save();

      if($area){
        return redirect()->route('warehouses-area.index')->with('success', 'Area Warehouse ['.$request->name.'] edited.');
      } else {
        return redirect()->route('warehouses-area.index')->with('error', 'Edit Area Warehouse failed.');
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
        $warehouse->status = 0;
        $warehouse->save();
      }

      $area = Area::find($id);
      $name = $area->name;
      $area->status = 0;
      $area->save();

      if($area){
        return redirect()->route('warehouses-area.index')->with('success', 'Area Warehouse ['.$name.'] deleted.');
      } else {
        return redirect()->route('warehouses-area.index')->with('error', 'Delete Area Warehouse failed.');
      }
      
    }
}
