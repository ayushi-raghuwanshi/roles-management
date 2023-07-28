<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        $fileName = '';
        if($file = $request->file('imageUpload')) {
            if (!Storage::disk('local')->exists('images/')) {
                Storage::disk('local')->makeDirectory('images/', 0775, true, true);
            }
            $fileName   = time() . $file->getClientOriginalName();
            Storage::disk('local')->put('images/' . $fileName, File::get($file));
            unlink(storage_path("app/public/images/".Auth::user()->avatar));
        }
        $user = User::find(Auth::id());
        $user->name = ($request->has('name')) ? $request->name : Auth::user()->name;
        $user->avatar = $fileName;
        $user->save();
        if (request()->ajax()) {
            return true;
        }
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
