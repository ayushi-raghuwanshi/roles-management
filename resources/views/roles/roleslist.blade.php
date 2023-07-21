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
                            <h5 class="card-title">Roles</h5>
                        </div>
                        <div class="col-md-1 mt-3">
                            <a href="{{ route('addrole') }}" class="btn btn-success"><i class="bi bi-plus"></i></a>
                        </div>
                    </div>
                    <!-- Table with stripped rows -->
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Permissions</th>
                                <th scope="col">Total Users</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Updated At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <th scope="row">{{ $role->id }}</th>
                                    <td>{{ $role->title }}</td>
                                    <td>
                                        @foreach($role->permissions as $key => $item)
                                            <span class="badge bg-primary"><i class="bi bi-star me-1"></i>{{$item->title}}</span>
                                        @endforeach
                                    </td>
                                    <td><span class="badge bg-secondary text-light">{{$role->users_count}}</span></td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>{{ $role->updated_at }}</td>
                                    <td>
                                    @can('update-role')<a href="{{ route('editRole',array('id'=>$role->id)) }}" class="btn btn-success"><i class="bi bi-pencil-fill"></i></a>@endcan</td>
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
