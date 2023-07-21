@extends('layouts.main')
@section('section')
    <div class="row">
        <form method="post" action="{{route('updateRole')}}">
            @csrf
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Role</h5>
                <div class="row">
                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Title</label>
                        <input type="text" class="form-control" id="inputNanme4" name ="title" value="{{$role->title}}">
                        @error('title')
                            <span style="color:red">{{$errors->first('title')}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6 mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Permissions</h5>
                <!-- List group With Checkboxes and radios -->
                @if (!empty($permissions))
                    @foreach ($permissions as $permission)
                        <div class="form-check form-switch form-check-inline">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="permissions[]" value="{{$permission->id}}" {{isset($role) && $role->permissions->contains($permission->id) ? 'checked' : ''}}>
                            <label class="form-check-label" for="flexSwitchCheckChecked">{{$permission->title}}</label>
                        </div>
                    @endforeach
                @endif
                <!-- End List Checkboxes and radios -->
            </div>
        </div>
        <input type="hidden" name="id" value="{{$role->id}}">
        </form>
    </div>
@endsection
