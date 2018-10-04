<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Model\AdminCity;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = $this->user->getByRoles(1);
      return view('users.index', compact('user'));
    }

    public function list_admincity()
    {
      $user = $this->user->getAllAdminCity();
      return view('users.list_admincity', compact('user'));
    }

    public function list_superadmin()
    {
      $user = $this->user->getByRoles(3);
      return view('users.list_superadmin', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_admincity()
    {
      return view('users.create_admincity');
    }

    public function create_superadmin()
    {
      return view('users.create_superadmin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if($request->roles_id == "2" || $request->roles_id == 2) {
            $admin = AdminCity::create([
                'user_id'      => $request->user,
                'city_id'      => $request->city_id,
            ]);
            $user       = $this->user->find($request->user);
        } else {
            $user       = $this->user->find($request->user_id);
        }
        $user->roles_id = $request->roles_id;
        $user->status   = 1;
        $user->save();

        if($user){
            if($user->roles_id == 2){
                return redirect()->route('user.list_admincity')->with('success', 'Success add admin city ['.$user->first_name.'].');
            } else if($user->roles_id == 3){
                return redirect()->route('user.list_superadmin')->with('success', 'Success add super admin ['.$user->first_name.'].');
            } 
        } else {
            if($user->roles_id == 2){
                return redirect()->route('user.list_admincity')->with('error', 'Add admin city failed.');
            } else if($user->roles_id == 3){
                return redirect()->route('user.list_superadmin')->with('error', 'Add super admin failed.');
            } 
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
        $user      = $this->user->getEdit($id);
        return view('users.edit', compact('user', 'id'));
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
        $user           = $this->user->findAdmin($id);
        $user->user_id  = $request->user;
        $user->city_id  = $request->city_id;
        $user->save();

        if($user){
            return redirect()->route('user.list_admincity')->with('success', 'Succes edit data admin city.');
        } else {
            return redirect()->route('user.list_admincity')->with('error', 'Edit admin city failed.');
        }     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->roles_id == '3'){
            $user  = $this->user->find($id);
        } else if ($request->roles_id == '2'){
            $cek   = $this->user->findAdmin($id);
            $user  = $this->user->find($cek->user_id);
            $cek->delete();
        }        
        $user->roles_id = 1;
        $user->save();

        if($user){
            if($request->roles_id == '2'){
                return redirect()->route('user.list_admincity')->with('success', 'Succes delete admin city ['.$user->first_name.'].');
            } else if($user->roles_id == 3){
                return redirect()->route('user.list_superadmin')->with('success', 'Succes delete super admin ['.$user->first_name.'].');
            } 
        } else {
            if($request->roles_id == '2'){
                return redirect()->route('user.list_admincity')->with('error', 'Delete admin city failed.');
            } else if($user->roles_id == '3'){
                return redirect()->route('user.list_superadmin')->with('error', 'Delete super admin failed.');
            } 
        }   
    }

    public function getDataSelectNotAdmin($args = []){

        $user       = $this->user->getSelectAllnotAdmin();
        $arrUser    = array();
        foreach ($user as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id,
                      'text'  =>  $arrVal->first_name .' '. $arrVal->last_name .' ('. $arrVal->email .')');
            $arrUser[] = $arr;
        }
        echo(json_encode($arrUser));
    }

    public function getDataSelectNotSuperadmin($args = []){

        $user       = $this->user->getSelectAllnotSuperadmin();
        $arrUser    = array();
        foreach ($user as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id,
                      'text'  =>  $arrVal->first_name .' '. $arrVal->last_name .' ('. $arrVal->email .')');
            $arrUser[] = $arr;
        }
        echo(json_encode($arrUser));
    }

}
