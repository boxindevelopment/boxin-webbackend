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
        'count_box' => 'required',
      ]);

      $type_size = TypeSize::where('id', $request->type_size_id)->first();
      $name = $request->name;
      if($name == ''){
        $name = $type_size->name;
      }
      $split     = explode('##', $request->space_id);
      $space_id  = $split[0];
      $id_name   = $split[1];

      for($i=0; $i<$request->count_box;$i++){
        $sql        = Box::where('space_id', '=', $space_id)->orderBy('id_name', 'desc')->first();
        $id_number  = isset($sql->id_name) ? substr($sql->id_name, 9) : 0;
        $code       = str_pad($id_number + 1, 3, "0", STR_PAD_LEFT);

        $box = Box::create([
          'types_of_size_id'  => $request->type_size_id,
          'space_id'          => $space_id,
          'name'              => $name,
          'location'          => $request->location,
          'id_name'           => $id_name.'1'.$code,
          'barcode'           => $id_name.'1'.$code,
          'status_id'         => 10,
        ]);
        $box->save();
      }
      if($box){
        return redirect()->route('box.index')->with('success', 'Add : [' . $name . '] success.');
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
      $split     = explode('##', $request->space_id);
      $space_id  = $split[0];
      $box                    = $this->box->find($id);
      $box->name              = $request->name;
      $box->types_of_size_id  = $request->type_size_id;
      $box->location          = $request->location;
      if($box->space_id != $space_id){
        $box->space_id        = $space_id;
        $box->id_name         = $request->id_name_box;
        $box->barcode         = $request->id_name_box;
      }   
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Edit ['.$request->name.'] success.');
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
      $produk  = $this->box->getById($id);
      $no = 1; 
      $pdf =  PDF::loadView('boxes.barcode'  ,  compact('produk','no')); 
      $pdf->setPaper('a7',  'landscape'); 
      return $pdf->stream(); 
    }

    public function getNumber(Request $request)
    {
        $space_id= $request->input('space_id');
        $sql     = Box::where('space_id', '=', $space_id)
                  ->orderBy('id_name', 'desc')
                  ->first();
        $id_number = isset($sql->id_name) ? substr($sql->id_name, 9) : 0;
        $code      = str_pad($id_number + 1, 3, "0", STR_PAD_LEFT);

        return $code;
    }

}
