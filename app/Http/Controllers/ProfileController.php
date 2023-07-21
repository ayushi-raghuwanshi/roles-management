<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangePasswordRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with(['roles'])->where('id',Auth::id())->first();
        return view('userprofile.profile',compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->save();
        return redirect()->route('profile')->with('success','Profile Updated Successfully');
    }

    public function changeSettings(Request $request)
    {
        $user = User::find($request->id);
        $user->roles()->sync($request->get('roles',[]));
        return redirect()->route('profile')->with('success','Profile Settings Updated Successfully');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::find($request->id);
        $user->password = $request->newpassword;
        $user->save();
        return redirect()->route('profile')->with('success','Profile Password Updated Successfully');
    }
}
