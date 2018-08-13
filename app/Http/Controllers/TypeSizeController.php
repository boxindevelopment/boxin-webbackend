<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TypeSize;

class TypeSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $boxes   = TypeSize::where('types_of_box_room_id', 1)->get();
      $rooms   = TypeSize::where('types_of_box_room_id', 2)->get();
      return view('settings.types-of-size.index', compact('boxes', 'rooms'));
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
      abort('404');   
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
      $data     = TypeSize::where('id',$id)->get();
      return view('settings.types-of-size.edit', compact('data', 'id'));
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
            'name'  => 'required',
            'size'  => 'required',
        ]);

        $data          = TypeSize::find($id);
        $data->name    = $request->name;
        $data->size    = $request->size;
        $data->save();

        if($data){
            return redirect()->route('types-of-size.index')->with('success', 'Edit Data Types of Size success.');
        } else {
            return redirect()->route('types-of-size.index')->with('error', 'Edit Data Types of Size failed.');
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
      
    }
}
