@extends('layouts.main')
@section('section')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Update User</h5>
                <!-- Custom Styled Validation -->
                <form class="row g-3" autocomplete="off" action="{{route('updateUser')}}" method="post">
                    @csrf
                    <div class="col-md-6">
                        <label for="validationCustom01" class="form-label">Name</label>
                        <input type="text" class="form-control" id="validationCustom01" name="name" value="{{$user->name}}">
                        @if($errors->has('name'))
                        <span style="color: red">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom02" class="form-label">Email</label>
                        <input type="email" class="form-control" id="validationCustom02" name="email" value="{{$user->email}}" disabled>
                        @if($errors->has('email'))
                        <span style="color: red">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom03" class="form-label">Password</label>
                        <input type="password" class="form-control" id="validationCustom03" name="password" value="{{$user->password}}">
                        @if($errors->has('password'))
                        <span style="color: red">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="validationCustom04" class="form-label">Role</label>
                        <select class="form-select" id="validationCustom04" name="roles[]" multiple>
                          <option value="">----Select Role----</option>
                          @foreach ($roles as $key => $value)
                            <option value="{{$key}}" {{isset($user) && $user->roles->contains($key) ? 'selected' : ''}}>{{$value}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                    <input type="hidden" name="id" value="{{$user->id}}">
                </form><!-- End Custom Styled Validation -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom_scripts')
<script type="text/javascript">
    $( '#validationCustom04' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        closeOnSelect: false,
    } );
</script>
@endpush

