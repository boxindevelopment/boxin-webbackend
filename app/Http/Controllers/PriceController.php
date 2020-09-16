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
        $rooms   = $this->price->all(2);
        return view('settings.price.index', compact('rooms'));
    }

    public function getAjax(Request $request)
    {

        $search = $request->input("search");
        $args = array();
        $args['box_or_room_id'] = $request->input('box_or_room_id');
        $args['searchRegex'] = ($search['regex']) ? $search['regex'] : false;
        $args['searchValue'] = ($search['value']) ? $search['value'] : '';
        $args['draw'] = ($request->input('draw')) ? intval($request->input('draw')) : 0;
        $args['length'] =  ($request->input('length')) ? intval($request->input('length')) : 10;
        $args['start'] =  ($request->input('start')) ? intval($request->input('start')) : 0;

        $order = $request->input("order");
        $args['orderDir'] = ($order[0]['dir']) ? $order[0]['dir'] : 'DESC';
        $orderNumber = ($order[0]['column']) ? $order[0]['column'] : 0;
        $columns = $request->input("columns");
        $args['orderColumns'] = ($columns[$orderNumber]['name']) ? $columns[$orderNumber]['name'] : 'prices.id';

        $price = $this->price->getData($args);

        $recordsTotal = count($price);

        $recordsFiltered = $this->price->getCount($args);

        $arrOut = array('draw' => $args['draw'], 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => '');
        $arr_data = array();
        $no = 0;
        foreach ($price as $arrVal) {
            $no++;

            $arr = array(
                      'no'                      => $no,
                      'id'                      => $arrVal->id,
                      'area_name'               => $arrVal->area_name,
                      'types_of_size_name'      => $arrVal->types_of_size_name,
                      'price'                   => $arrVal->price,
                      'duration'                => $arrVal->duration);
                $arr_data['data'][] = $arr;

        }

        $arrOut = array_merge($arrOut, $arr_data);
        echo(json_encode($arrOut));
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
             //6month
            $price4 = Price::create([
              'types_of_box_room_id'    => $r->type_of_box_room_id,
              'area_id'                 => $area_id,
              'types_of_size_id'        => $r->type_size_id,
              'types_of_duration_id'    => 7,
              'price'                   => $r->sixmonth_price,
            ]);
            $price4->save();
            //annual
            $price5 = Price::create([
              'types_of_box_room_id'    => $r->type_of_box_room_id,
              'area_id'                 => $area_id,
              'types_of_size_id'        => $r->type_size_id,
              'types_of_duration_id'    => 8,
              'price'                   => $r->annual_price,
            ]);
            $price5->save();
        }

        if($price5){
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
