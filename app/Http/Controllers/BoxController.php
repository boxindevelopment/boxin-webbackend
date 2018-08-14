<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Box;
use App\Model\Space;
use App\Model\TypeSize;
use Carbon;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $box      = Box::where('deleted_at', NULL)->orderBy('name', 'asc')->get();
      $space    = Space::where('deleted_at', NULL)->orderBy('name')->get();
      $type_size = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();
      return view('boxes.index', compact('box', 'space', 'type_size'));
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
        'space_id'  => 'required',
        'type_size_id' => 'required',
      ]);

      $type_size = TypeSize::where('id', $request->type_size_id)->get();
      $name = $request->name;
      if($name == ''){
        $name = $type_size[0]->name.' Room';
      }
      $box = Box::create([
        'types_of_size_id'  => $request->type_size_id,
        'space_id'          => $request->space_id,
        'name'              => $name,
        'location'          => $request->location,
        'status_id'         => 10,
      ]);

      if($box){
        return redirect()->route('box.index')->with('success', 'Add : [' . $name . ' Box] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Add New Box failed.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $box      = Box::find($id);
      $space    = Space::where('deleted_at', NULL)->orderBy('name')->get();
      $type_size = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();
      return view('boxes.edit', compact('id', 'box', 'space', 'type_size'));
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
        'space_id'      => 'required',
        'type_size_id'  => 'required',
      ]);

      $type_size              = TypeSize::where('id', $request->type_size_id)->get();
      $name = $request->name;
      if($name == ''){
        $name = $type_size[0]->name.' Room';
      }
      $box                = Box::find($id);
      $box->name          = $name;
      $box->type_size_id  = $request->type_size_id;
      $box->space_id      = $request->space_id;
      $box->location      = $request->location;
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Edit ['.$box->name.'] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Edit Box failed.');
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
      $box  = Box::find($id);
      $name = $box->name;
      $box->deleted_at = Carbon\Carbon::now();
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Delete ['.$name.'] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Edit Box failed.');
      }
    }

}
