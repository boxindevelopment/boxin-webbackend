<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Category;
use Validator;
use DB;

class CategoryController extends Controller
{
    
    public function index()
    {
        $data   = Category::get();
        return view('category.index', compact('data'));
    }

    public function create()
    {
        abort('404');
    }

    public function store(Request $request)
    {
        $data = Category::create([
            'name'          => $request->name,
            'description'   => $request->description,
        ]);

        if($data){
            return redirect()->route('category.index')->with('success', 'Add New Data Category Success.');
        } else {
            return redirect()->route('category.index')->with('error', 'Add New Data Category failed.');
        }         
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
        $data = Category::where('id', $id)->get();
        return view('category.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $data          = Category::find($id);
        $data->name    = $request->name;
        $data->description = $request->description;
        $data->save();

        if($data){
            return redirect()->route('category.index')->with('success', 'Edit Data Category success.');
        } else {
            return redirect()->route('category.index')->with('error', 'Edit Data Category failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}
