<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Box;
use App\Model\Space;
use App\Model\Shelves;
use App\Model\TypeSize;
use Carbon;
use App\Repositories\BoxRepository;
use PDF;

class BoxController extends Controller
{
    protected $repository;

    public function __construct(BoxRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $box      = $this->repository->all();
        return view('boxes.index', compact('box'));
    }

    public function create()
    {
        $type_size = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();
        return view('boxes.create', compact('type_size'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'shelves_id'  => 'required',
            'type_size_id' => 'required',
            'code_box' => 'required',
            'count_box' => 'required',
        ]);

        $box = Box::where('code_box', $request->input('code_box'))
             ->where('deleted_at', NULL)
             ->first();

        if($box){
            return redirect()->route('box.index')->with('error', 'Add New Box failed (code is used).');
        }

        $type_size = TypeSize::where('id', $request->type_size_id)->first();
        $name = $request->name;
        if($name == ''){
            $name = $type_size->name;
        }

        $split        = explode('##', $request->shelves_id);
        $shelves_id   = $split[0];
        $id_name      = $split[1];

        for($i=0; $i<$request->count_box;$i++){
            $no = $i+1;
            if($request->count_box == 1){
                $name_box = $name;
            }else{
                $name_box = $name.' '.$no;
            }

            $box = Box::create([
                        'types_of_size_id'  => $request->type_size_id,
                        'shelves_id'        => $shelves_id,
                        'name'              => $name_box,
                        'location'          => $request->location,
                        'id_name'           => $request->code_box,
                        'barcode'           => $request->code_box,
                        'code_box'          => $request->code_box,
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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
      $box       = $this->repository->getEdit($id);
      $type_size = TypeSize::where('types_of_box_room_id', 1)->orderBy('id')->get();
      $edit_box  = true;
      return view('boxes.edit', compact('id', 'box', 'type_size', 'edit_box'));
    }

    public function update(Request $request, $id)
    {
      $split      = explode('##', $request->shelves_id);
      $shelves_id = $split[0];
      $box                    = $this->repository->find($id);
      $box->name              = $request->name;
      $box->types_of_size_id  = $request->type_size_id;
      $box->location          = $request->location;
      if($box->shelves_id != $shelves_id){
        $box->shelves_id      = $shelves_id;
      }
      if($request->code_box != ''){
        $box->id_name         = $request->code_box;
        $box->barcode         = $request->code_box;
        $box->code_box         = $request->code_box;
      }
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Edit ['.$request->name.'] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Edit Box failed.');
      }
    }

    public function destroy($id)
    {
      $box  = $this->repository->find($id);
      $name = $box->name;
      $box->deleted_at = Carbon\Carbon::now();
      $box->save();

      if($box){
        return redirect()->route('box.index')->with('success', 'Delete ['.$name.'] success.');
      } else {
        return redirect()->route('box.index')->with('error', 'Edit Box failed.');
      }
    }

    public  function printBarcode($id)
    {
      $produk  = $this->repository->getById($id);
      $no = 1;
      $pdf =  PDF::loadView('boxes.barcode'  ,  compact('produk','no'));
      $pdf->setPaper('a7',  'landscape');
      return $pdf->stream();
    }

    public function getNumber(Request $request)
    {
        $sql     = Box::where('shelves_id', '=', $request->input('shelves_id'))
                  ->where('deleted_at', NULL)
                  ->orderBy('id_name', 'desc')
                  ->first();
        $id_number = isset($sql->id_name) ? substr($sql->id_name, 9) : 0;
        $code      = str_pad($id_number + 1, 3, "0", STR_PAD_LEFT);

        return $code;
    }

    public function checkCode(Request $request)
    {
        $box     = Box::where('code_box', $request->input('code_box'))
                  ->where('deleted_at', NULL)
                  ->first();

        if($box){
            return 'used';
        } else {
            return 'not';
        }
    }

    public function resetNumber(Request $request)
    {
        $boxes    = Box::whereNull('code_box')->get();
        foreach ($boxes as $k => $v) {
            if(!is_null($v->shelves_id)){
                $shelves = Shelves::find($v->shelves_id);
                if($shelves){
                    $shelvesCode = $shelves->code_shelves;
                    $v->code_box = $shelvesCode . 'B1010101';
                    $v->save();
                }
            }
        }

        echo(json_encode($boxes));
    }

}
