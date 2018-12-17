<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Voucher;
use Carbon;
use App\Repositories\VoucherRepository;
use DB;

class VoucherController extends Controller
{

    protected $repository;

    public function __construct(VoucherRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $data  = $this->repository->all();
      return view('vouchers.index', compact('data'));
    }

    public function create()
    {
      return view('vouchers.create');
    }

    public function store(Request $r)
    {
      $this->validate($r, [
          'image' => 'image|mimes:jpeg,png,jpg',
      ]);
      $data = false;
      if ($r->hasFile('image')) {
          if ($r->file('image')->isValid()) {
              $getimageName = time().'.'.$r->image->getClientOriginalExtension();
              $image = $r->image->move(public_path('images/voucher'), $getimageName);
              $data = Voucher::create([
                  'name'            => $r->name,
                  'code'            => $r->code,
                  'description'     => $r->description,
                  'start_date'      => $r->start_date,
                  'end_date'        => $r->end_date,
                  'type_voucher'    => $r->type_voucher,
                  'value'           => $r->type_voucher == '1' ? $r->value1 : $r->value2,
                  'image'           => $getimageName,
              ]);
              $data->save();
          }
      }        
      if($data){        
        return redirect()->route('voucher.index')->with('success', 'Voucher : [' . $r->name . '] inserted.');
      } else {
        return redirect()->route('voucher.index')->with('error', 'Add New Voucher failed.');
      }
      
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $data = $this->repository->find($id);
      return view('vouchers.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
      $data                 = $this->repository->find($id);
      $data->name           = $request->name;
      $data->code           = $request->code;
      $data->description    = $request->description;
      $data->start_date     = $request->start_date;
      $data->end_date       = $request->end_date;
      $data->value          = $request->type_voucher == '1' ? $request->value1 :$request->value2;
      $data->type_voucher   = $request->type_voucher;
      $data->save();

      if($data){
        return redirect()->route('voucher.index')->with('success', 'Voucher successfully edited.');
      } else {
        return redirect()->route('voucher.index')->with('error', 'Edit Voucher failed.');
      }
    }

    public function destroy($id)
    {      
      $data     = Voucher::find($id);
      $data->deleted_at = Carbon\Carbon::now();
      $data->status_id  = 21;
      $data->save();
      
      if($data){
        return redirect()->route('voucher.index')->with('success', 'Voucher successfully deleted.');
      } else {
        return redirect()->route('voucher.index')->with('error', 'Delete Voucher failed.');
      }
    }

}
