<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Entities\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Response;
use Hash;


class NewuserController extends Controller
{

  public function __construct()
  {
    $this->middleware(['permission:admin_panel']);
  }

    public function index()
    {
      // $user = User::withTrashed()->where('id', 2)->first();
      // $user->deleted_at = null;
      // $user->save();
      // dd($user->deleted_at);
      // dd(User::withTrashed()->where('id', 2)->get());
      // $a = $user->first();
      // dd($a->getRoleNames()->first());

      $user = User::withTrashed()->orderBy('name', 'asc')->get();
      return view('Adminpanel.listuser', compact('user'));
    }

    public function setStatus(Request $request)
    {
      $this->validate($request,[
        'id' => 'required|exists:users'
      ]);

      $id   = $request->id;
      $user = User::withTrashed()->where('id', $id)->first();
      $name = $user->name;
      $text = '';
      if (!empty($user->deleted_at)){
        $user->deleted_at = null;
        $user->save();

        $text = 'Aktifkan';
      } else {
        $user->delete();

        $text = 'Non-Aktifkan';
      }
      return redirect()->route('new-user.index')->with('success', 'User ['.$name.'] di ' . $text);
    }

    public function create_user()
    {
      $role = Role::all();
      return view('Adminpanel.newuser', compact('role'));
    }

    public function save_user(Request $request)
    {
      // dd($request);
      $this->validate($request, [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|max:255',
        'password' => 'required|max:255',
      ]);

      $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
      ]);
      $user->assignRole($request->role);

      return redirect()->route('new-user.index')->with('success', 'User ['.$request->name.' - '.$request->role.'] added');
    }

    public function edit_user($id)
    {
      $user = User::find($id);
      $role = Role::all();
      return view('Adminpanel.edituser', compact('user', 'role', 'id'));
    }

    public function update_user($id, Request $request)
    {
      $this->validate($request, [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|max:255',
        'role' => 'required',
      ]);

      $role  = null;
      $name  = null;
      $email = null;

      $user = User::find($id);
      if ($request->name != $user->name){
        $name = $request->name;
      } else {
        $name = $user->name;
      }

      if ($request->email != $user->email){
        $email = $request->email;
      } else {
        $email = $user->email;
      }


      if ($request->role != $user->role){
        $role = $request->role;
      } else {
        $role = $user->role;
      }

      $user->name  = $name;
      $user->email = $email;
      $user->save();

      $user->syncRoles($role);
      return redirect()->route('new-user.index')->with('success', 'User ['.$name.'] successfully edited');
    }

    public function newrole()
    {

      return view('Adminpanel.newrole');
    }

    public function saverole(Request $request)
    {
      $name = $request->name;
      Role::create(['name' => $name]);
      return redirect()->route('new-user.listrole')->with('success', 'Successfully added new role ['.$name.']');
    }


    public function listrole()
    {
      $role = Role::all();
      return view('Adminpanel.listrole', compact('role'));
    }

    public function viewpermission($name)
    {
      $role = Role::findByName($name);
      $data = array(
        'member_new'      => 0,
        'member_list'     => 0,
        'wallet_add'      => 0,
        'wallet_list'     => 0,
        'wd_pending'      => 0,
        'wd_approve'      => 0,
        'categoryproduct' => 0,
      );
      foreach ($role->permissions as $key => $value) {
        $data[$value->name] = 1;
      }
      return view('Adminpanel.settingrole', compact('name', 'data'));
    }

    public function setPermission($name, Request $request)
    {
      $arr = array();
      if ($request->has('member_new')) {
        $arr[] = 'member_new';
      }
      if ($request->has('member_list')) {
        $arr[] = 'member_list';
      }

      if ($request->has('wallet_add')) {
        $arr[] = 'wallet_add';
      }
      if ($request->has('wallet_list')) {
        $arr[] = 'wallet_list';
      }

      if ($request->has('wd_pending')) {
        $arr[] = 'wd_pending';
      }
      if ($request->has('wd_approve')) {
        $arr[] = 'wd_approve';
      }

      if ($request->has('categoryproduct')) {
        $arr[] = 'categoryproduct';
      }

      $role = Role::findByName($name);
      $role->syncPermissions($arr);

      return redirect()->route('new-user.listrole')->with('success', 'Role has been set.');
    }


}
