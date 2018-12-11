<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Setting;
use Validator;
use DB;

class SettingController extends Controller
{
    
    public function index()
    {
        $data   = Setting::get();
        return view('settings.others.index', compact('data'));
    }

    public function create()
    {
        abort('404');
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
        $data = Setting::where('id', $id)->get();
        return view('settings.others.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $data               = Setting::find($id);
        $data->value        = $request->value;
        $data->description  = $request->description;
        $data->save();

        if($data){
            return redirect()->route('settings.index')->with('success', 'Edit Data setting success.');
        } else {
            return redirect()->route('settings.index')->with('error', 'Edit Data setting failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}
