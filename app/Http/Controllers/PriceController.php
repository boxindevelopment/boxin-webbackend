<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Price;
use App\Repositories\PriceRepository;

class PriceController extends Controller
{
    protected $price;

    public function __construct(PriceRepository $price)
    {
        $this->price = $price;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $boxes   = $this->price->all(1);
      $rooms   = $this->price->all(2);
      return view('settings.price.index', compact('boxes', 'rooms'));
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
      abort('404');   
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
      $data     = $this->price->getById($id);
      return view('settings.price.edit', compact('data', 'id'));
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
