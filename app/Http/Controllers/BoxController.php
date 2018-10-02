<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Box;
use App\Model\Space;
use App\Model\TypeSize;
use Carbon;
use App\Repositories\BoxRepository;
use PDF;

class BoxController extends Controller
{
    protected $box;

    public function __construct(BoxRepository $box)
    {
        $this->box = $box;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $box      = $this->box->all();
      return view('boxes.index', compact('box'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $type_size = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();
      return view('boxes.create', compact('type_size'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'space_id'  => 'required',
        'type_size_id' => 'required',
      ]);

      $type_size = TypeSize::where('id', $request->type_size_id)->get();
      $name = $request->name;
      if($name == ''){
        $name = $type_size[0]->name;
      }
      
      $box = Box::create([
        'types_of_size_id'  => $request->type_size_id,
        'space_id'          => $request->space_id,
        'name'              => $name,
        'location'          => $request->location,
        'status_id'         => 10,
      ]);

      $boxes    = $this->box->find($box->id);
      $date     = strtotime($boxes->created_at);
      $barcode  = $date .''. rand(01, 99) .''. $box->id;
      $boxes->barcode = $barcode;
      $boxes->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Add : [' . $name . ' Box] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Add New Box failed.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $box      = $this->box->getEdit($id);
      $box      = $box[0];
      $type_size = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();
      return view('boxes.edit', compact('id', 'box', 'type_size'));
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
        'space_id'      => 'required',
        'type_size_id'  => 'required',
      ]);

      $type_size              = TypeSize::where('id', $request->type_size_id)->get();
      $name = $request->name;
      if($name == ''){
        $name = $type_size[0]->name;
      }
      $box                = $this->box->find($id);
      $box->name          = $name;
      $box->types_of_size_id  = $request->type_size_id;
      $box->space_id      = $request->space_id;
      $box->location      = $request->location;
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Edit ['.$box->name.'] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Edit Box failed.');
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
      $box  = $this->box->find($id);
      $name = $box->name;
      $box->deleted_at = Carbon\Carbon::now();
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Delete ['.$name.'] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Edit Box failed.');
      }
    }

    public  function printBarcode($id){ 
      // $produk =  Box::limit(12)->get(); 
      $produk  = $this->box->getById($id);
      $no = 1; 
      $pdf =  PDF::loadView('boxes.barcode'  ,  compact('produk','no')); 
      $pdf->setPaper('a7',  'landscape'); 
      return $pdf->stream(); 
    }

}
