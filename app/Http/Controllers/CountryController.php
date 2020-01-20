<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Province;
use App\Model\Regency;
use App\Model\District;
use App\Model\Village;
use Carbon;
use DB;

class CountryController extends Controller
{

    public function __construct()
    {
    }

    public function getDataProvinceSelect(Request $request)
    {
        $provincies = Province::get();
        $arrProvincies = array();
        foreach ($provincies as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id,
                      'text'  =>  $arrVal->name);
            $arrProvincies[] = $arr;
        }
        echo(json_encode($arrProvincies));
    }

    public function getDataRegencySelect(Request $request)
    {
        $province_id = $request->input('province_id');
        $regencies = Regency::where('province_id', $province_id)->get();
        $arrRegencies = array();
        foreach ($regencies as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id,
                      'text'  =>  $arrVal->name);
            $arrRegencies[] = $arr;
        }
        echo(json_encode($arrRegencies));
    }

    public function getDataDistrictSelect(Request $request)
    {
        $regency_id = $request->input('regency_id');
        $districts = District::where('regency_id', $regency_id)->get();
        $arrDistricts = array();
        foreach ($districts as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id,
                      'text'  =>  $arrVal->name);
            $arrDistricts[] = $arr;
        }
        echo(json_encode($arrDistricts));
    }

    public function getDataVillageSelect(Request $request)
    {
        $district_id = $request->input('district_id');
        $villages = Village::where('district_id', $district_id)->get();
        $arrVillages = array();
        foreach ($villages as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id,
                      'text'  =>  $arrVal->name);
            $arrVillages[] = $arr;
        }
        echo(json_encode($arrVillages));
    }

}
