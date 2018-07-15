<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Cities;
use App\Entities\Area;

class CityWarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $city = Cities::where('status', 1)->orderBy('name')->get();
      return view('warehouses.list_city', compact('city'));
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
      $cities =Cities::create([
        'name' => $request->name
      ]);

      if($cities){
        return redirect()->route('warehouses-city.index')->with('success', 'City Warehouse : [' . $request->name . '] inserted.');
      } else {
        return redirect()->route('warehouses-city.index')->with('error', 'Add New City Warehouse failed.');
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
      $city = Cities::find($id);
      return view('warehouses.edit_city', compact('city', 'id'));
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
      $city           = Cities::find($id);
      $name           = $city->name;
      $city->name     = $request->name;
      $city->save();

      if($city){
        return redirect()->route('warehouses-city.index')->with('success', '['.$name.'] successfully edited.');
      } else {
        return redirect()->route('warehouses-city.index')->with('error', 'Edit City Warehouse failed.');
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
      $area_       = Area::where('city_warehouse_id', $id)->get();
      $count_area = count($area_);
      for ($i = 0; $i < $count_area; $i++) {
        $area = Area::find($area_[$i]->id);
        $area->status = 0;
        $area->save();
      }
      
      $city     = Cities::find($id);
      $name     = $city->name;
      $city->status = 0;
      $city->save();
      
      if($city){
        return redirect()->route('warehouses-city.index')->with('success', '['.$name.'] successfully deleted.');
      } else {
        return redirect()->route('warehouses-city.index')->with('error', 'Delete City Warehouse failed.');
      }

    }
}
