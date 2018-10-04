<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Setting;
use Validator;

class SettingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data   = Setting::get();
        return view('settings.setting.index', compact('data'));
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
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        
        $this->validate($request,[
            'name'  => 'required|without_spaces|unique:settings,name|max:255',
            'value' => 'required',
        ]);

        $data = Setting::create([
            'name'       => $request->name,
            'value'      => $request->value,
        ]);

        if($data){
            return redirect()->route('setting.index')->with('success', 'Add New Data Setting Success.');
        } else {
            return redirect()->route('setting.index')->with('error', 'Add New Data Setting failed.');
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
      $data     = Setting::where('id',$id)->get();
      return view('settings.setting.edit', compact('data', 'id'));
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
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        $this->validate($request, [
            'name'  => 'required|without_spaces|max:255',
            'value' => 'required',
        ]);

        $data          = Setting::find($id);
        $data->name    = $request->name;
        $data->value   = $request->value;
        $data->save();

        if($data){
            return redirect()->route('setting.index')->with('success', 'Edit Data Setting success.');
        } else {
            return redirect()->route('setting.index')->with('error', 'Edit Data Setting failed.');
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
