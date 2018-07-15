<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Warehouse;
use App\Entities\Area;
use App\Entities\Space;

class WarehousesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $warehouse = Warehouse::where('status', 1)->orderBy('name')->get();
      return view('warehouses.index', compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $area = Area::where('status', 1)->orderBy('name')->get();
      return view('warehouses.create', compact('area'));
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

      $area_id  = $request->area_id;
      $name     = $request->name;
      $longitude= $request->longitude;
      $latitude = $request->latitude;

      $warehouses = Warehouse::create([
        'name'      => $name,
        'area_id'   => $area_id,
        'long'      => $longitude,
        'lat'       => $latitude,
      ]);

      $name = $warehouses->name;

      if($warehouses){
        return redirect()->route('warehouses.index')->with('success', 'New Warehouse ['.$name.'] added.');
      } else {
        return redirect()->route('warehouses.index')->with('error', 'Add New Warehouse failed.');
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
      $area       = Area::orderBy('name')->get();
      $warehouse  = Warehouse::find($id);
      return view('warehouses.edit', compact('area', 'id', 'warehouse'));
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
      $this->validate($request,[
        'name' => 'required|max:255',
      ]);

      $area_id  = $request->area_id;
      $name     = $request->name;
      $longitude= $request->longitude;
      $latitude = $request->latitude;

      $warehouse  = Warehouse::find($id);
      $warehouse->name      = $name;
      $warehouse->area_id   = $area_id;
      $warehouse->long      = $longitude;
      $warehouse->lat       = $latitude;
      $warehouse->save();

      if($warehouse){
        return redirect()->route('warehouses.index')->with('success', 'Warehouse ['.$name.'] edited.');
      } else {
        return redirect()->route('warehouses.index')->with('error', 'Edit Warehouse failed.');
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
      $space_       = Space::where('warehouse_id', $id)->get();
      $count_space  = count($space_);
      for ($i = 0; $i < $count_space ; $i++) {
        $space = Space::find($space_[$i]->id);
        $space->status = 0;
        $space->save();
      }

      $warehouse = Warehouse::find($id);
      $name = $warehouse->name;
      $warehouse->status = 0;
      $warehouse->save();

      if($warehouse){
        return redirect()->route('warehouses.index')->with('success', 'Warehouse ['.$name.'] deleted.');
      } else {
        return redirect()->route('warehouses.index')->with('error', 'Delete Warehouse failed.');
      }

    }

}
