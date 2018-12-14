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

    public function store(Request $request)
    {
      $data = Voucher::create([
        'name'            => $request->name,
        'code'            => $request->code,
        'description'     => $request->description,
        'start_date'      => $request->start_date,
        'end_date'        => $request->end_date,
        'value'           => $request->value,
        'type_voucher'    => $request->type_voucher,
      ]);

      if($data){        
        return redirect()->route('voucher.index')->with('success', 'Voucher : [' . $request->name . '] inserted.');
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
      $data->value          = $request->value;
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
      $data->save();
      
      if($data){
        return redirect()->route('voucher.index')->with('success', 'Voucher successfully deleted.');
      } else {
        return redirect()->route('voucher.index')->with('error', 'Delete Voucher failed.');
      }
    }

}
