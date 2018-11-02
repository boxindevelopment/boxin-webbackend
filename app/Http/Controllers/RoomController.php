<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Space;
use App\Model\Room;
use App\Model\TypeSize;
use Carbon;
use App\Repositories\RoomRepository;

class RoomController extends Controller
{
    protected $room;

    public function __construct(RoomRepository $room)
    {
        $this->room = $room;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $room   = $this->room->all();
      return view('rooms.index', compact('room'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $type_size = TypeSize::where('types_of_box_room_id', 2)->orderBy('id')->get();
      return view('rooms.create', compact('type_size'));
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
      $split     = explode('##', $request->space_id);
      $space_id  = $split[0];
      $id_name   = $split[1];

      $sql        = Room::where('space_id', '=', $space_id)->orderBy('id_name', 'desc')->first();
      $id_number  = isset($sql->id_name) ? substr($sql->id_name, 9) : 0;
      $code       = str_pad($id_number + 1, 3, "0", STR_PAD_LEFT);

      $room = Room::create([
        'name'              => $name,
        'space_id'          => $space_id,
        'types_of_size_id'  => $request->type_size_id,
        'id_name'           => $id_name.'2'.$code,
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
      $room     = $this->room->getEdit($id);
      $room     = $room[0];
      $type_size= TypeSize::where('types_of_box_room_id', 2)->orderBy('id')->get();
      $edit_room= true;
      return view('rooms.edit', compact('room', 'id', 'type_size', 'edit_room'));
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
      $split     = explode('##', $request->space_id);
      $space_id  = $split[0];

      $room                   = $this->room->find($id);
      $room->name             = $request->name;
      $room->types_of_size_id = $request->type_size_id;
      if($room->space_id != $space_id){
        $room->space_id        = $space_id;
        $room->id_name         = $request->id_name_room;
      }   
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
      $room  = $this->room->find($id);
      $name  = $room->name;
      $room->deleted_at = Carbon\Carbon::now();
      $room->save();

      if($room){
        return redirect()->route('room.index')->with('success', 'Delete ['.$name.'] success.');
      } else {
        return redirect()->route('room.index')->with('error', 'Delete Room failed.');
      }
    }

    public function getNumber(Request $request)
    {
        $space_id= $request->input('space_id');
        $sql     = Room::where('space_id', '=', $space_id)
                  ->orderBy('id_name', 'desc')
                  ->first();
        $id_number = isset($sql->id_name) ? substr($sql->id_name, 9) : 0;
        $code      = str_pad($id_number + 1, 3, "0", STR_PAD_LEFT);

        return $code;
    }
}
