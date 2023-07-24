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
        $users = User::with(['subusers'])->where('id',Auth::id())->withCount(['subusers','todaysubusers'])
        ->with(['todaysubusers' => function($q) {
            $q->take(5)->latest();
        }])
        ->withCount([
            'tasks',
            'tasks as pending_task' => function($query){
                $query->where('status','=','Pending');
            },
            'tasks as inprogress_task' => function($query){
                $query->where('status','=','Inprogress');
            },
            'tasks as completed_task' => function($query){
                $query->where('status','=','Completed');
            }
        ])
        ->first();
        $total_users = User::count();
        return view('dashboard',compact('users','total_users'));
    }
}
