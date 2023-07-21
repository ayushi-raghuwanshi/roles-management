<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with(['todaysubusers','subusers'])->where('id',Auth::id())->withCount('subusers')->withCount('todaysubusers')->get()->map(function ($query) {
            $query->setRelation('todaysubusers', $query->todaysubusers->take(2));
            return $query;
        });
        $total_users = User::count();
        return view('dashboard',compact('users','total_users'));
    }
}
