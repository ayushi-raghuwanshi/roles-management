<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function index()
    {
        abort_if(\Gate::denies('view-permission'),'403');
        $permissions = Permission::get();
        return view('permissions.permissionlist',compact('permissions'));
    }

    public function createPermission()
    {
        abort_if(\Gate::denies('add-permission'),'403');
        return view('permissions.add_permission');
    }

    public function storePermission(PermissionRequest $request)
    {
        Permission::create($request->all());
        return redirect()->route('permission')->with('success','Permission Added Successfully!');
    }

    public function editPermission($id)
    {
        abort_if(\Gate::denies('update-permission'),'403');
        $permission = Permission::find($id);
        return view('permissions.add_permission')->with('permission',$permission);
    }

    public function updatePermission(UpdatePermissionRequest $request)
    {
        unset($request['_token']);
        Permission::where('id',$request->id)->update($request->all());
        return redirect()->route('permission')->with('success','Permission Updated Successfully!');;
    }
}
