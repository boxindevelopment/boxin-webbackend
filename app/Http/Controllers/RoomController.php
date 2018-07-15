<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Space;
use App\Entities\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $room   = Room::where('status', 1)->orderBy('name')->get();
      $space  = Space::where('status', 1)->orderBy('name')->get();
      return view('rooms.index', compact('room','space'));
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

      $space_id     = $request->space_id;
      $name         = $request->name;

      $room = Room::create([
        'name'      => $name,
        'space_id'  => $space_id,
      ]);

      if($room){
        return redirect()->route('room.index')->with('success', 'Room Warehouse ['.$request->name.'] added.');
      } else {
        return redirect()->route('room.index')->with('error', 'Add New Room Warehouse failed.');
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
      $room     = Room::find($id);
      $space    = Space::where('status', 1)->orderBy('name')->get();
      return view('rooms.edit', compact('room', 'id', 'space'));
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
      $room       = Room::find($id);
      $room->name = $request->name;
      $room->space_id = $request->space_id;
      $room->save();

      if($room){
        return redirect()->route('room.index')->with('success', 'Room Warehouse ['.$request->name.'] edited.');
      } else {
        return redirect()->route('room.index')->with('error', 'Edit Room Warehouse failed.');
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
      $room  = Room::find($id);
      $name  = $room->name;
      $room->status = 0;
      $room->save();

      if($room){
        return redirect()->route('room.index')->with('success', 'Room Warehouse ['.$name.'] deleted.');
      } else {
        return redirect()->route('room.index')->with('error', 'Delete Room Warehouse failed.');
      }
      
    }
}
