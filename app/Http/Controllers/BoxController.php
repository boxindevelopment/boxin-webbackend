<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Boxes;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $box = Boxes::where('status', 1)->orderBy('name', 'asc')->get();
      return view('boxes.index', compact('box'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('boxes.create');
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
        'name' => 'required',
      ]);

      $box = Boxes::create([
        'name'      => $request->name,
        'location'  => $request->location,
        'size'      => $request->size,
        'price'     => $request->price 
      ]);

      if($box){
        return redirect()->route('box.index')->with('success', 'Box : [' . $request->name . '] inserted.');
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
      $box = Boxes::find($id);
      return view('boxes.edit', compact('id', 'box'));
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
        'name' => 'required',
      ]);

      $box           = Boxes::find($id);
      $name          = $box->name;
      $box->name     = $request->name;
      $box->location = $request->location;
      $box->size     = $request->size;
      $box->price    = $request->price;
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Box ['.$name.'] successfully edited.');
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
      $box  = Boxes::find($id);
      $name = $box->name;
      $box->status = 0;
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Box ['.$name.'] deleted.');
      } else {
        return redirect()->route('box.index')->with('error', 'Edit Box failed.');
      }
    }

}
