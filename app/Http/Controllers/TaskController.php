<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function index()
    {
        abort_if(\Gate::denies('view-task'),'403');
        $tasks = Task::with(['user'])->where('assigned_by',\Auth::id())->get();
        return view('task.tasklist',compact('tasks'));
    }

    public function createTask()
    {
        abort_if(\Gate::denies('add-task'),'403');
        $users = User::with(['subusers'])->where('id',\Auth::id())->first();
        return view('task.addtask',compact('users'));
    }

    public function storeTask(StoreTaskRequest $request)
    {
        $request->merge(['assigned_by'=>\Auth::id()]);
        Task::create($request->all());
        return redirect()->route('task')->with('success','Task Added Successfully');
    }

    public function editTask($id)
    {
        abort_if(\Gate::denies('update-task'),'403');
        $users = User::with(['subusers'])->where('id',\Auth::id())->first();
        $task = Task::find($id);
        return view('task.updatetask',compact('task','users'));
    }

    public function updateTask(UpdateTaskRequest $request)
    {
        unset($request['_token']);
        Task::where('id',$request->id)->update($request->all());
        return redirect()->route('task')->with('success','Task Updated Successfully');
    }
}
