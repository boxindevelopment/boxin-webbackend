<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Banner;
use Carbon;
use App\Repositories\BannerRepository;
use DB;

class BannerController extends Controller
{

    protected $repository;

    public function __construct(BannerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
      $data  = $this->repository->all();
      return view('promotions.banners.index', compact('data'));
    }

    public function create()
    {
      return view('promotions.banners.create');
    }

    public function store(Request $r)
    {
      $this->validate($r, [
          'image' => 'image|mimes:jpeg,png,jpg',
      ]);

      if ($r->hasFile('image')) {
          if ($r->file('image')->isValid()) {
              $getimageName = time().'.'.$r->image->getClientOriginalExtension();
              $image = $r->image->move(public_path('images/banner'), $getimageName);
              $data = Banner::create([
                  'name'            => $r->name,
                  'image'           => $getimageName,
              ]);
              $data->save();
          }
      }        
      if($data){        
        return redirect()->route('banner.index')->with('success', 'Banner : [' . $r->name . '] inserted.');
      } else {
        return redirect()->route('banner.index')->with('error', 'Add New Banner failed.');
      }
      
    }

    public function show($id)
    {
      abort('404');
    }

    public function edit($id)
    {
      $data = $this->repository->find($id);
      return view('promotions.banners.edit', compact('data', 'id'));
    }

    public function update(Request $request, $id)
    {
      $data                 = $this->repository->find($id);
      $data->name           = $request->name;
      $data->status_id      = $request->status_id;
      if ($request->hasFile('image')) {
        if ($request->file('image')->isValid()) {
            $getimageName = time().'.'.$request->image->getClientOriginalExtension();
            $image = $request->image->move(public_path('images/banner'), $getimageName);
            $data->image = $getimageName;
        }
      }
      $data->save();

      if($data){
        return redirect()->route('banner.index')->with('success', 'Banner successfully edited.');
      } else {
        return redirect()->route('banner.index')->with('error', 'Edit Banner failed.');
      }
    }

    public function destroy($id)
    {      
      $data     = Banner::find($id);
      $data->deleted_at = Carbon\Carbon::now();
      $data->status_id  = 21;
      $data->save();
      
      if($data){
        return redirect()->route('banner.index')->with('success', 'Banner successfully deleted.');
      } else {
        return redirect()->route('banner.index')->with('error', 'Delete Banner failed.');
      }
    }

}
