<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\City;
use App\Model\Area;
use App\Model\Price;
use Carbon;
use App\Repositories\CityRepository;
use DB;

class CityController extends Controller
{

    protected $city;

    public function __construct(CityRepository $city)
    {
        $this->city = $city;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $id_name  = $this->id_name();
      $city     = $this->city->all();
      return view('warehouses.list_city', compact('city', 'id_name'));
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
      $cities = City::create([
        'name' => $request->name,
        'id_name' => $request->id_name,
      ]);

      if($cities){
        $this->city->insertPrice($cities->id);
        
        return redirect()->route('warehouses-city.index')->with('success', 'Warehouse City : [' . $request->name . '] inserted.');
      } else {
        return redirect()->route('warehouses-city.index')->with('error', 'Add New Warehouse City failed.');
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
      $city = City::find($id);
      return view('warehouses.edit_city', compact('city', 'id'));
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
      $city           = City::find($id);
      $name           = $city->name;
      $city->name     = $request->name;
      $city->id_name  = $request->id_name;
      $city->save();

      if($city){
        return redirect()->route('warehouses-city.index')->with('success', '['.$name.'] successfully edited.');
      } else {
        return redirect()->route('warehouses-city.index')->with('error', 'Edit Warehouse City failed.');
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
      $area_       = Area::where('city_id', $id)->get();
      $count_area  = count($area_);
      for ($i = 0; $i < $count_area; $i++) {
        $area = Area::find($area_[$i]->id);
        $area->deleted_at = Carbon\Carbon::now();
        $area->save();
      }
      
      $city     = City::find($id);
      $name     = $city->name;
      $city->deleted_at = Carbon\Carbon::now();
      $city->save();
      
      if($city){
        return redirect()->route('warehouses-city.index')->with('success', '['.$name.'] successfully deleted.');
      } else {
        return redirect()->route('warehouses-city.index')->with('error', 'Delete Warehouse City failed.');
      }

    }

    public function getDataSelect(Request $request){

        $cities = $this->city->getSelect();
        $arrCities = array();
        foreach ($cities as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id,
                      'text'  =>  $arrVal->name);
            $arrCities[] = $arr;
        }
        echo(json_encode($arrCities));

    }

    private function id_name()
    {

        $sql    = City::orderBy('number', 'desc')->first(['id_name', DB::raw('substring(id_name,1,2) as number')]);
        $number = isset($sql->number) ? $sql->number : 0;
        $code   = str_pad($number + 1, 2, "0", STR_PAD_LEFT);

        return $code;

    }

}
