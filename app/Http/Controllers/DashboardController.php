<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Repositories\DashboardRepository;

class DashboardController extends Controller
{
    protected $data;

    public function __construct(DashboardRepository $data)
    {
        $this->data = $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user      = $request->user();
        $city      = $this->data->countCity();
        $area      = $this->data->countArea();
        $space     = $this->data->countSpace();
        $available_space = $this->data->countSpaceAvailable();
        $box       = $this->data->countBox();
        $shelves   = $this->data->countShelves();
        $available_box      = $this->data->countBoxAvailable();
        $totalSales         = $this->data->totalSales();
        $totalSalesMonth    = $this->data->totalSalesMonth();
        $me                 = Auth::id();
        return view('dashboard', compact('city', 'space', 'box', 'area', 'me', 'available_space', 'available_box', 'shelves', 'totalSales', 'totalSalesMonth'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
