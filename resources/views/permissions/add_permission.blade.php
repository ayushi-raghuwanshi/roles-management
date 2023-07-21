@extends('layouts.main')
@section('section')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{@$permission->id ? 'Update' : 'Add'}} Permission</h5>
                    <!-- Vertical Form -->
                    @if(!empty($permission))
                        <form class="row g-3" method="post"  action="{{route('updatePermission')}}" >
                        <input type="hidden" name="id" value="{{$permission->id}}">
                    @else
                        <form class="row g-3" method="post"  action="{{route('storePermission')}}" >
                    @endif
                        @csrf
                        <div class="col-12">
                            <label for="inputNanme4" class="form-label">Title</label>
                            <input type="text" class="form-control" id="inputNanme4" name ="title" value="{{$permission->title ?? ''}}">
                            @error('title')
                                <span style="color:red">{{$errors->first('title')}}</span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form><!-- Vertical Form -->
                </div>
            </div>
        </div>
    </div>
@endsection
