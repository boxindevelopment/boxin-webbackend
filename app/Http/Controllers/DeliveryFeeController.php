<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\DeliveryFee;
use Validator;
use DB;

class DeliveryFeeController extends Controller
{
    
    public function index()
    {
        $data   = DeliveryFee::get();
        return view('settings.delivery-fee.index', compact('data'));
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
        $delfee = DeliveryFee::select(array('delivery_fee.*', DB::raw('(cities.id) as city_id'), DB::raw('(cities.id_name) as city_id_name'),
                DB::raw('(areas.id) as area_id'), DB::raw('(areas.id_name) as area_id_name')))
                ->leftJoin('areas', 'areas.id', '=' ,'delivery_fee.area_id')
                ->leftJoin('cities', 'cities.id', '=', 'areas.city_id')
                ->where('delivery_fee.id',$id)->first();
        $edit_delfee = true;
        return view('settings.delivery-fee.edit', compact('delfee', 'id', 'edit_delfee'));
    }

    public function update(Request $request, $id)
    {
        $data          = DeliveryFee::find($id);
        $data->fee     = $request->fee;
        $data->save();

        if($data){
            return redirect()->route('delivery-fee.index')->with('success', 'Edit Data Delivery Fee success.');
        } else {
            return redirect()->route('delivery-fee.index')->with('error', 'Edit Data Delivery Fee failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}
