<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Space;
use App\Model\Room;
use App\Model\TypeSize;
use Carbon;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $room   = Room::where('deleted_at', NULL)->orderBy('name')->get();
      $space  = Space::where('deleted_at', NULL)->orderBy('name')->get();
      $type_size = TypeSize::where('types_of_box_room_id', 2)->orderBy('id')->get();
      return view('rooms.index', compact('room','space', 'type_size'));
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
      $this->validate($request, [
        'space_id'          => 'required',
        'type_size_id'      => 'required',
      ]);

      $type_size = TypeSize::where('id', $request->type_size_id)->get();
      $name = $request->name;
      if($name == ''){
        $name = $type_size[0]->name;
      }
      $room = Room::create([
        'name'              => $name,
        'space_id'          => $request->space_id,
        'types_of_size_id'  => $request->type_size_id,
        'status_id'         => 10,
      ]);

      if($room){
        return redirect()->route('room.index')->with('success', 'Add ['.$name.' Room] success.');
      } else {
        return redirect()->route('room.index')->with('error', 'Add New Room failed.');
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
      $space    = Space::where('deleted_at', NULL)->orderBy('name')->get();
      $type_size= TypeSize::where('types_of_box_room_id', 2)->orderBy('id')->get();
      return view('rooms.edit', compact('room', 'id', 'space', 'type_size'));
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
      $this->validate($request, [
        'space_id'  => 'required',
        'type_size_id' => 'required',
      ]);

      $type_size              = TypeSize::where('id', $request->type_size_id)->get();
      $name = $request->name;
      if($name == ''){
        $name = $type_size[0]->name;
      }
      $room                   = Room::find($id);
      $room->name             = $name;
      $room->types_of_size_id = $request->type_size_id;
      $room->space_id         = $request->space_id;
      $room->save();

      if($room){
        return redirect()->route('room.index')->with('success', 'Edit ['.$room->name.'] success.');
      } else {
        return redirect()->route('room.index')->with('error', 'Edit Room  failed.');
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
      $room->deleted_at = Carbon\Carbon::now();
      $room->save();

      if($room){
        return redirect()->route('room.index')->with('success', 'Delete ['.$name.'] success.');
      } else {
        return redirect()->route('room.index')->with('error', 'Delete Room failed.');
      }

    }
}
