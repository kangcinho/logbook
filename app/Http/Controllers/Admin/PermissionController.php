<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Http\Requests\PermissionRequestForm;
class PermissionController extends Controller
{
    public function showPermission(){
      return view('admin.permission.showPermission',compact('permissions'));
    }

    public function tambahPermission(PermissionRequestForm $request){
      $permission = new Permission([
        'name' => $request->name,
        'display_name' => $request->display_name,
        'description' => $request->description,
      ]);
      $permission->save();
      $status = "Data Permission: <b>".$permission->display_name."</b> berhasil disimpan.";
      return response()->json(array('msg' => $status));
    }

    public function getPermission(){
      $permissions = Permission::all();
      return response()->json(array('msg' => $permissions));
    }
}
