<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        abort_if(\Gate::denies('view-role'),'403');
        $roles = Role::with(['permissions'])->withCount(['users'])->get();
        return view('roles.roleslist',compact('roles'));
    }

    public function createRole()
    {
        abort_if(\Gate::denies('add-role'),'403');
        $permissions = Permission::all();
        return view('roles.add_role',compact('permissions'));
    }

    public function storeRole(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->get('permissions',[]));
        return redirect()->route('role')->with('success','Role Added Successfully!');
    }

    public function editRole($id)
    {
        abort_if(\Gate::denies('update-role'),'403');
        $role = Role::with(['permissions'])->where('id',$id)->first();
        $permissions = Permission::all();
        return view('roles.edit_role',compact('role','permissions'));
    }

    public function updateRole(UpdateRoleRequest $request)
    {
        $role = Role::find($request->id);
        $role->title = $request->title;
        $role->save();
        $role->permissions()->sync($request->get('permissions',[]));
        return redirect()->route('role')->with('success','Role Updated Successfully!');
    }
}
