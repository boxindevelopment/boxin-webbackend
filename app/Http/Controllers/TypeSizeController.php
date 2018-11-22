<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TypeSize;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
USE File;

class TypeSizeController extends Controller
{

    public function index()
    {
      $boxes   = TypeSize::where('types_of_box_room_id', 1)->get();
      $rooms   = TypeSize::where('types_of_box_room_id', 2)->get();
      return view('settings.types-of-size.index', compact('boxes', 'rooms'));
    }

    public function createBox()
    {
      return view('settings.types-of-size.create_box');
    }

    public function createRoom()
    {
      return view('settings.types-of-size.create_room');
    }

    public function store(Request $r)
    {
        $this->validate($r, [
            'name'  => 'required',
            'size'  => 'required',
            'image' => 'image|mimes:jpeg,png,jpg',
        ]);
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $getimageName = time().'.'.$request->image->getClientOriginalExtension();
                $image = $request->image->move(public_path('images/types_of_size'), $getimageName);
                $data = TypeSize::create([
                    'type_of_box_room_id' => $r->type_of_box_room_id,
                    'name'                => $r->name,
                    'size'                => $r,
                    'image'               => $getimageName,
                ]);
            }
        }        

        if($data){
            return redirect()->route('types-of-size.index')->with('success', 'Success add data size.');
        } else {
            return redirect()->route('types-of-size.index')->with('error', 'Add data size failed.');
        }     
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $data     = TypeSize::where('id',$id)->get();
      return view('settings.types-of-size.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'  => 'required',
            'size'  => 'required',
            'image' => 'image|mimes:jpeg,png,jpg',
        ]);

        $data          = TypeSize::find($id);
        $data->name    = $request->name;
        $data->size    = $request->size;
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $getimageName = time().'.'.$request->image->getClientOriginalExtension();
                $image = $request->image->move(public_path('images/types_of_size'), $getimageName);
                $data->image = $getimageName;
            }
        }
        $data->save();

        if($data){
            return redirect()->route('types-of-size.index')->with('success', 'Edit Data Size success.');
        } else {
            return redirect()->route('types-of-size.index')->with('error', 'Edit Data Size failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}
