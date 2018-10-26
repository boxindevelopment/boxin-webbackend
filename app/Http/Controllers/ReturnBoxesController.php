<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ReturnBoxes;
use App\Repositories\ReturnBoxesRepository;

class ReturnBoxesController extends Controller
{
    protected $repository;

    public function __construct(ReturnBoxesRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data   = $this->repository->all();
      return view('returnbox.index', compact('data'));
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
      $data     = $this->repository->getById($id);
      return view('returnbox.edit', compact('data', 'id'));
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
            'status_id'  => 'required',
        ]);

        $return                 = ReturnBoxes::find($id);
        $return->status_id      = $request->status_id;
        $return->driver_name    = $request->driver_name;
        $return->driver_phone   = $request->driver_phone;
        $return->deliver_fee    = $request->deliver_fee;
        $return->save();

        if($return){
            return redirect()->route('return.index')->with('success', 'Edit Data Return Boxes success.');
        } else {
            return redirect()->route('return.index')->with('error', 'Edit Data Return Boxes failed.');
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
