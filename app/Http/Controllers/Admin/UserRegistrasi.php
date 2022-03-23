<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Userlog;
use App\Http\Requests\UserFormRequest;

class UserRegistrasi extends Controller
{
    public function userlog(){
      $userlogs = Userlog::all();
      return view('admin.userlog.showUserLog',compact('userlogs'));
    }

    public function getUser(){
      $users = User::with('roles')->get();
      return response()->json(['msg' => $users]);
    }

    public function showUser(){
      return view('admin.user.showUser');
    }

    public function formTambahUser(){
      $roles = Role::pluck('name','id');
      return view('admin.user.formUser',compact('roles'));
    }

    public function tambahUser(UserFormRequest $request){
      $user = new User([
        'name' => $request->name,
        'username' => $request->username,
        'password' => bcrypt($request->password)
      ]);
      $user->save();
      $user->roles()->sync($request->roles);
      $status = "User: <b>".$user->name."</b> berhasil disimpan.";
      return redirect('admin/user')->with('status',$status);
    }

    public function formEditUser($id){
      $roles = Role::pluck('name','id');
      $user = User::with('roles')->where('id',$id)->firstOrFail();
      return view('admin.user.formUser',compact('user','roles'));
    }

    public function editUser(UserFormRequest $request, $id){
      $user = User::where('id', $id)->firstOrFail();
      $user->name = $request->name;
      $user->username = $request->username;
      if($request->password){
        $user->password = bcrypt($request->password);
      }
      $user->save();
      $user->roles()->sync($request->roles);

      $status = "User: <b>".$user->name."</b> berhasil disimpan.";
      return redirect('admin/user')->with('status',$status);
    }

    public function deleteUser($id){
      $user = User::where('id', $id)->firstOrFail();
      $status = "User: <b>".$user->name."</b> berhasil dihapus.";
      $user->delete();
      return redirect('admin/user')->with('status',$status);
    }

}
