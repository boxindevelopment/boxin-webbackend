<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Model\AdminArea;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {
      $user = $this->user->getAll();
      return view('users.all.index', compact('user'));
    }

    //*================================================== ADMIN AREA ==================================================*\\
    public function list_admin()
    {
      $user = $this->user->getAdminByRoles(2);
      return view('users.admin.index', compact('user'));
    }

    public function storeAdmin(Request $request)
    {
      $split    = explode('##', $request->area_id);
      $area_id  = $split[0];
      $user_id  = $request->admin_id;

      $admin = AdminArea::create([
          'user_id'      => $user_id,
          'area_id'      => $area_id,
      ]);

      $user           = $this->user->find($user_id);
      $user->roles_id = $request->roles_id;
      $user->status   = 1;
      $user->save();

      if($user){
        return redirect()->route('user.admin.index')->with('success', 'Success add admin area ['.$user->first_name.'].');
      } else {
        return redirect()->route('user.admin.index')->with('error', 'Add admin area failed.');
      }   
    }
    //*================================================== END ADMIN AREA ==================================================*\\

    //*=================================================== ADMIN FINANCE ==================================================*\\
    public function list_finance()
    {
      $user = $this->user->getAdminByRoles(4);
      return view('users.finance.index', compact('user'));
    }

    public function storeFinance(Request $request)
    {
      $split    = explode('##', $request->area_id);
      $area_id  = $split[0];
      $user_id  = $request->finance_id;

      $admin = AdminArea::create([
          'user_id'      => $user_id,
          'area_id'      => $area_id,
      ]);
      
      $user           = $this->user->find($user_id);
      $user->roles_id = $request->roles_id;
      $user->status   = 1;
      $user->save();

      if($user){
        return redirect()->route('user.finance.index')->with('success', 'Success add admin finance ['.$user->first_name.'].');
      } else {
        return redirect()->route('user.finance.index')->with('error', 'Add admin finance failed.');
      }   
    }
    //*================================================== END ADMIN FINANCE ==================================================*\\

    //*====================================================== SUPERADMIN ======================================================*\\
    public function list_superadmin()
    {
      $user = $this->user->getSuperadmin();
      return view('users.superadmin.index', compact('user'));
    }

    public function storeSuperadmin(Request $request)
    {      
      $user           = $this->user->find($request->superadmin_id);
      $user->roles_id = $request->roles_id;
      $user->status   = 1;
      $user->save();

      if($user){
        return redirect()->route('user.superadmin.index')->with('success', 'Success add super admin ['.$user->first_name.'].');
      } else {
        return redirect()->route('user.superadmin.index')->with('error', 'Add super admin failed.');
      }   
    }
    //*==================================================== END SUPERADMIN ====================================================*\\

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user      = $this->user->getEdit($id); 
        $edit_user = true;
        if($user->roles_id == '2'){
          return view('users.admin.edit', compact('user', 'id', 'edit_user'));
        }else{
          return view('users.finance.edit', compact('user', 'id', 'edit_user'));
        }
    }

    public function update(Request $request, $id)
    {
        $split    = explode('##', $request->area_id);
        $area_id  = $split[0];
        $user_id  = $request->admin_id != null ? $request->admin_id : $request->finance_id ;
        
        $user           = $this->user->findAdmin($id);
        $cek_user       = $this->user->find($user_id);
        if($cek_user){
          $cek_user->status   = '1';          
          $cek_user->roles_id = $request->roles_id;
          $cek_user->save();
        }
        $user->user_id  = $user_id;
        $user->area_id  = $area_id;
        $user->save();

        if($user){
          if($request->roles_id == '2'){
            return redirect()->route('user.admin.index')->with('success', 'Succes edit data admin area.');
          }else{
            return redirect()->route('user.finance.index')->with('success', 'Succes edit data admin finance.');
          }
        } else {
          if($request->roles_id == '2'){
            return redirect()->route('user.admin.index')->with('error', 'Edit admin area failed.');
          }else{
            return redirect()->route('user.finance.index')->with('error', 'Edit admin finance failed.');
          }
        }     
    }

    public function destroy(Request $request, $id)
    {
        if($request->roles_id == '3' || $request->roles_id == '1'){
            $user  = $this->user->find($id);
        } else if ($request->roles_id == '2' || $request->roles_id == '4'){
            $cek   = $this->user->findAdmin($id);
            $user  = $this->user->find($cek->user_id);
            $cek->delete();
        } 
           
        $user->roles_id = 1;
        $user->save();

        if($user){
            if($request->roles_id == '2'){
                return redirect()->route('user.admin.index')->with('success', 'Succes delete admin area ['.$user->first_name.'].');
            } else if($request->roles_id == '3'){
                return redirect()->route('user.superadmin.index')->with('success', 'Succes delete super admin ['.$user->first_name.'].');
            } else if($request->roles_id == '4'){
                return redirect()->route('user.finance.index')->with('success', 'Succes delete admin finance ['.$user->first_name.'].');
            } else if($request->roles_id == '1'){
                return redirect()->route('user.all.index')->with('success', 'Succes delete costumer ['.$user->first_name.'].');
            } 
        } else {
            if($request->roles_id == '2'){
                return redirect()->route('user.admin.index')->with('error', 'Delete admin area failed.');
            } else if($request->roles_id == '3'){
                return redirect()->route('user.superadmin.index')->with('error', 'Delete super admin failed.');
            } else if($request->roles_id == '4'){
                return redirect()->route('user.finance.index')->with('error', 'Delete admin finance failed.');
            } else if($request->roles_id == '1'){
                return redirect()->route('user.all.index')->with('error', 'Delete customer failed.');
            } 
        }   
    }

    public function getDataSelectForAdmin($args = []){

        $user       = $this->user->getSelectAllForAdmin();
        $arrUser    = array();
        foreach ($user as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id,
                      'text'  =>  $arrVal->first_name .' '. $arrVal->last_name .' ('. $arrVal->email .')');
            $arrUser[] = $arr;
        }
        echo(json_encode($arrUser));
    }

    public function getDataSelectForSuperadmin($args = []){

        $user       = $this->user->getSelectAllForSuperadmin();
        $arrUser    = array();
        foreach ($user as $arrVal) {
            $arr = array(
                      'id'    => $arrVal->id,
                      'text'  =>  $arrVal->first_name .' '. $arrVal->last_name .' ('. $arrVal->email .')');
            $arrUser[] = $arr;
        }
        echo(json_encode($arrUser));
    }

    public function getDataSelectForFinance($args = []){

        $user       = $this->user->getSelectAllForFinance();
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
