<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrderDetailRepository;

class OrderDetailController extends Controller
{
    protected $repository;

    public function __construct(OrderDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $order   = $this->repository->all();
      return view('storage.index', compact('order'));
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

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    
    }

    public function orderDetailBox($id)
    {
        $detail             = $this->repository->getOrderDetail($id);
        $detail_order_box   = $this->repository->getDetailBox($id);
        return view('storage.box-detail', compact('detail_order_box', 'id', 'detail'));
    }
}
