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
                            <h5 class="card-title">Users</h5>
                        </div>
                        @can('add-user')
                            <div class="col-md-1 mt-3">
                                <a href="{{ route('createUser') }}" class="btn btn-success"><i class="bi bi-plus"></i></a>
                            </div>
                        @endcan
                    </div>
                    <!-- Table with stripped rows -->
                    <table class="table table-striped datatable" id="userTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Role</th>
                                <th scope="col">Email</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Updated At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users->subusers as $user)
                                <tr>
                                    <th scope="row">{{$user->id ?? ''}}</th>
                                    <td>{{$user->name ?? ''}}</td>
                                    <td>
                                        @foreach($user->roles as $key => $item)
                                            <span class="badge bg-success"><i class="bi bi-person-fill me-1"></i>{{$item->title}}</span>
                                        @endforeach
                                    </td>
                                    <td>{{$user->email ?? ''}}</td>
                                    <td>{{$user->created_at ?? ''}}</td>
                                    <td>{{$user->updated_at ?? ''}}</td>
                                    @can('update-user')
                                    <td>
                                        <a href="{{ route('editUser',array('id'=>$user->id)) }}" class="btn btn-success"><i class="bi bi-pencil-fill"></i></a>
                                        <a href="{{ route('loginAsOtherUser',array('id'=>$user->id)) }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Login"><i class="bi bi-box-arrow-in-right"></i></a>
                                    </td>
                                    @endcan
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
