<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Role;
use App\Models\User;
use App\Models\UserSubuser;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        abort_if(\Gate::denies('view-user'),'403');
        $users = User::with(['subusers','roles'])->where('id',Auth::id())->withCount('subusers')->first();
        return view('users.userslist',compact('users'));
    }

    public function createUser(){
        abort_if(\Gate::denies('add-user'),'403');
        $roles = Role::pluck('title','id');
        return view('users.add_user',compact('roles'));
    }

    public function storeUser(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->get('roles',[]));
        $sub_user = new UserSubuser();
        $sub_user->user_id = Auth::id();
        $sub_user->sub_user_id = $user->id;
        $sub_user->save();
        return redirect()->route('users')->with('success','User Created Successfully!');
    }

    public function editUser($id)
    {
        abort_if(\Gate::denies('update-user'),'403');
        $roles = Role::pluck('title','id');
        $user = User::with(['roles'])->where('id',$id)->first();
        return view('users.update_user',compact('user','roles'));
    }

    public function updateUser(UpdateUserRequest $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->password = $request->password;
        $user->save();
        $user->roles()->sync($request->input('roles',[]));
        return redirect()->route('users')->with('success','User Updated Successfully!');
    }
}
