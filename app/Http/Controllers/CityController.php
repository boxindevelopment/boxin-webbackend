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

    protected $repository;

    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $id_name  = $this->id_name();
      $city     = $this->repository->all();
      return view('cities.index', compact('city', 'id_name'));
    }

    public function create()
    {
      abort('404');
    }

    public function store(Request $request)
    {
      $cities = City::create([
        'name'    => $request->name,
        'id_name' => $request->id_name,
      ]);

      if($cities){        
        return redirect()->route('city.index')->with('success', 'City : [' . $request->name . '] inserted.');
      } else {
        return redirect()->route('city.index')->with('error', 'Add New City failed.');
      }
      
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $city = $this->repository->find($id);
      return view('cities.edit', compact('city', 'id'));
    }

    public function update(Request $request, $id)
    {
      $city           = $this->repository->find($id);
      $name           = $city->name;
      $city->name     = $request->name;
      $city->id_name  = $request->id_name;
      $city->save();

      if($city){
        return redirect()->route('city.index')->with('success', '['.$name.'] successfully edited.');
      } else {
        return redirect()->route('city.index')->with('error', 'Edit City failed.');
      }
    }

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
        return redirect()->route('city.index')->with('success', '['.$name.'] successfully deleted.');
      } else {
        return redirect()->route('city.index')->with('error', 'Delete City failed.');
      }
    }

    public function getDataSelect(Request $request)
    {
        $cities = $this->repository->getSelect();
        $arrCities = array();
        foreach ($cities as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id . '##' . $arrVal->id_name,
                      'text'  =>  $arrVal->name);
            $arrCities[] = $arr;
        }
        echo(json_encode($arrCities));
    }

    private function id_name()
    {
        $sql    = City::where('deleted_at', NULL)->orderBy('number', 'desc')->first(['id_name', DB::raw('substring(id_name,1,2) as number')]);
        $number = isset($sql->number) ? $sql->number : 0;
        $code   = str_pad($number + 1, 2, "0", STR_PAD_LEFT);

        return $code;
    }
}
