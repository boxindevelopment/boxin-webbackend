<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Space;
use App\Model\Warehouse;
use App\Model\Room;
use Carbon;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $space      = Space::where('deleted_at', NULL)->orderBy('name')->get();
      $warehouse  = Warehouse::where('deleted_at', NULL)->orderBy('name')->get();
      return view('spaces.index', compact('space','warehouse'));
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

      $warehouse_id = $request->warehouse_id;
      $name         = $request->name;

      $space = Space::create([
        'name'              => $name,
        'warehouse_id'      => $warehouse_id,
      ]);

      if($space){
        return redirect()->route('space.index')->with('success', 'Space Warehouse ['.$request->name.'] added.');
      } else {
        return redirect()->route('space.index')->with('error', 'Add New Space Warehouse failed.');
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
      $space      = Space::find($id);
      $warehouse  = Warehouse::where('deleted_at', NULL)->orderBy('name')->get();
      return view('spaces.edit', compact('space', 'id', 'warehouse'));
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
      $space       = Space::find($id);
      $space->name = $request->name;
      $space->warehouse_id = $request->warehouse_id;
      $space->save();

      if($space){
        return redirect()->route('space.index')->with('success', 'Space Warehouse ['.$request->name.'] edited.');
      } else {
        return redirect()->route('space.index')->with('error', 'Edit Space Warehouse failed.');
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
      $room_       = Room::where('space_id', $id)->get();
      $count_room  = count($room_);
      for ($i = 0; $i < $count_room ; $i++) {
        $room = Room::find($room_[$i]->id);
        $room->deleted_at = Carbon\Carbon::now();
        $room->save();
      }

      $space = Space::find($id);
      $name  = $space->name;
      $space->deleted_at = Carbon\Carbon::now();
      $space->save();

      if($space){
        return redirect()->route('space.index')->with('success', 'Space Warehouse ['.$name.'] deleted.');
      } else {
        return redirect()->route('space.index')->with('error', 'Delete Space Warehouse failed.');
      }
      
    }
}
