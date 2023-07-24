@extends('layouts.main')
@section('section')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h5 class="card-title">Tasks</h5>
                        </div>
                        <div class="col-md-1 mt-3">
                            <a href="{{ route('addtask') }}" class="btn btn-success"><i class="bi bi-plus"></i></a>
                        </div>
                    </div>
                    <!-- Table with stripped rows -->
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Updated At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                                <tr>
                                    <th scope="row">{{ $task->id }}</th>
                                    <td>{{ $task->name }}</td>
                                    <td>{!! $task->description !!}</td>
                                    <td>{{ $task->start_date }}</td>
                                    <td>{{ $task->end_date }}</td>
                                    <td>
                                        <span class="badge bg-success"><i class="bi bi-person-fill me-1"></i>{{$task->user->name ?? 'None'}}</span>
                                    </td>
                                    <td><span class="badge {{$task->priority == 'Low' ? 'bg-primary' : ($task->priority == 'Medium' ? 'bg-warning' : 'bg-danger')}} text-light">{{$task->priority}}</span></td>
                                    <td><span class="badge {{$task->status == 'Pending' ? 'bg-danger' : ($task->status == 'Inprogress' ? 'bg-warning' : 'bg-success')}} text-light">{{$task->status}}</span></td>
                                    <td>{{ $task->created_at }}</td>
                                    <td>{{ $task->updated_at }}</td>
                                    <td>
                                    @can('update-task')<a href="{{ route('editTask',array('id'=>$task->id)) }}" class="btn btn-success"><i class="bi bi-pencil-fill"></i></a>@endcan</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
