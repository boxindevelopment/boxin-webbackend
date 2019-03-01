<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ChangeBox;
use App\Model\OrderDetail;
use App\Repositories\ChangeBoxRepository;
use DB;
use Exception;

class ChangeBoxesController extends Controller
{
    protected $repository;

    public function __construct(ChangeBoxRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $data   = $this->repository->all();
      return view('changebox.index', compact('data'));
    }

    public function create()
    {
      abort('404');
    }

    public function store(Request $request)
    {
      abort('404');
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $data     = $this->repository->getById($id);
      return view('changebox.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status_id'  => 'required',
        ]);
        $status                 = $request->status_id;
        $change                 = ChangeBox::find($id);
        $change->status_id      = $status;
        $change->driver_name    = $request->driver_name;
        $change->driver_phone   = $request->driver_phone;
        $change->save();

        if($change){
            // $order               = OrderDetail::find($request->order_detail_id);
            // $order->status_id    = $status == '12' ? '4' : $status;
            // $order->save();
            return redirect()->route('change-box.index')->with('success', 'Edit Data Return Boxes success.');
        } else {
            return redirect()->route('change-box.index')->with('error', 'Edit Data Return Boxes failed.');
        }
    }

    public function destroy($id)
    {

    }
}
