<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Price;
use App\Model\TypeSize;
use App\Repositories\PriceRepository;

class PriceController extends Controller
{
    protected $price;

    public function __construct(PriceRepository $price)
    {
        $this->price = $price;
    }

    public function index()
    {
        $boxes   = $this->price->all(1);
        $rooms   = $this->price->all(2);
        return view('settings.price.index', compact('boxes', 'rooms'));
    }

    public function priceBox()
    {
        $type_size = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();
        return view('settings.price.create_box', compact('type_size'));
    }

    public function priceRoom()
    {
        $type_size = TypeSize::where('types_of_box_room_id', 2)->orderBy('id')->get();
        return view('settings.price.create_room', compact('type_size'));
    }

    public function store(Request $r)
    {
        $split      = explode('##', $r->area_id);
        $area_id    = $split[0];
        $check      = $this->price->checkPrice($r->type_of_box_room_id, $r->type_size_id, $area_id);
        if($check){
            return redirect()->route('price.index')->with('error', 'Add New Price failed. Prices in the area already exist.');
        }else{
            //day
            $price1 = Price::create([
              'types_of_box_room_id'    => $r->type_of_box_room_id,
              'area_id'                 => $area_id,
              'types_of_size_id'        => $r->type_size_id,
              'types_of_duration_id'    => 1,
              'price'                   => $r->daily_price,
            ]);
            $price1->save();
            //week
            $price2 = Price::create([
              'types_of_box_room_id'    => $r->type_of_box_room_id,
              'area_id'                 => $area_id,
              'types_of_size_id'        => $r->type_size_id,
              'types_of_duration_id'    => 2,
              'price'                   => $r->weekly_price,
            ]);
            $price2->save();
            //month
            $price3 = Price::create([
              'types_of_box_room_id'    => $r->type_of_box_room_id,
              'area_id'                 => $area_id,
              'types_of_size_id'        => $r->type_size_id,
              'types_of_duration_id'    => 3,
              'price'                   => $r->monthly_price,
            ]);
            $price3->save();
        }        

        if($price3){
            return redirect()->route('price.index')->with('success', 'New Price added.');
        } else {
            return redirect()->route('price.index')->with('error', 'Add New Price failed.');
        }
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $price      = $this->price->getEdit($id);
      $edit_price = true;
      return view('settings.price.edit', compact('price', 'id', 'edit_price'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'price'  => 'required',
        ]);

        $data          = Price::find($id);
        $data->price   = $request->price;
        $data->save();

        if($data){
            return redirect()->route('price.index')->with('success', 'Edit Data Price success.');
        } else {
            return redirect()->route('price.index')->with('error', 'Edit Data Price failed.');
        }
    }

    public function destroy($id)
    {
      
    }
}
