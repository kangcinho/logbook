<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\Http\Requests\RoleRequestForm;
class RoleController extends Controller
{
    public function showRole(){
      return view('admin.role.showRole');
    }

    public function formTambahRole(){
      $permission = Permission::pluck('name','id');
      $permission[''] = '';
      return view('admin.role.formRole', compact('permission'));
    }

    public function formEditRole($id){
      $permission = Permission::pluck('name','id');
      $permission[''] = '';
      $role = Role::with('permission')->where('id',$id)->firstOrFail();
      return view('admin.role.formRole',compact('role', 'permission'));
    }

    public function tambahRole(RoleRequestForm $request){
      $role = new Role([
        'name' => $request->name,
        'display_name' => $request->display_name,
        'description' => $request->description
      ]);
      $role->save();
      if(!in_array('',$request->permission)){
        $role->permission()->sync($request->permission);
      }

      return redirect('admin/role');
    }

    public function editRole(RoleRequestForm $request, $id){
      $role = Role::where('id',$id)->firstOrFail();
      $role->name = $request->name;
      $role->display_name = $request->display_name;
      $role->description = $request->description;
      $role->save();
      if(!in_array('',$request->permission)){
        $role->permission()->sync($request->permission);
      }
      return redirect('admin/role');
    }

    public function deleteRole($id){
      $role = Role::where('id',$id)->firstOrFail();
      $role->delete();
      return redirect('admin/role');
    }

    public function getRole(){
      $role = Role::with('permission')->get();
      return response()->json(['msg'=>$role]);
    }
}
