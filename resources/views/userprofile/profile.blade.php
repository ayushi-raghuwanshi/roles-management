@extends('layouts.main')
@section('custom_css')
    <style>
        #imageUpload {
            display: none;
        }

        #profileImage {
            cursor: pointer;
        }

        #profile-container {
            width: 150px;
            height: 150px;
            overflow: hidden;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            -o-border-radius: 50%;
            border-radius: 50%;
        }

        #profile-container img {
            width: 150px;
            height: 150px;
        }
    </style>
@endsection
@section('section')
    <div class="row">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <form id="avatar-form" enctype="multipart/form-data" method="POST">
                        <div id="profile-container">
                            @php
                                if(!empty($user->avatar)){
                                    $img_url = url('storage/images/'.$user->avatar);
                                }else{
                                    $img_url = "https://eu.ui-avatars.com/api/?name='$user->name'";
                                }
                            @endphp
                            <img src="{{$img_url}}" id="profileImage"
                                alt="Profile" class="rounded-circle" height="35%" width="35%">
                        </div>
                        <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo" required=""
                            capture>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                    <span>{{ $user->name }}</span>
                    <div class="social-links mt-2">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Overview</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                Profile</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-settings">Settings</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change
                                Password</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Profile Details</h5>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                            <!-- Profile Edit Form -->
                            <form method="post" action="{{ route('updateProfile') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="name" type="text" class="form-control" id="fullName"
                                            value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                                <input type="hidden" name="id" value="{{ $user->id }}">
                            </form><!-- End Profile Edit Form -->
                        </div>

                        <div class="tab-pane fade pt-3" id="profile-settings">
                            <!-- Settings Form -->
                            <form method="post" action="{{ route('changeSettings') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Roles</label>
                                    <div class="col-md-8 col-lg-9">
                                        @if (!empty($user->roles))
                                            @foreach ($user->roles as $role)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="changesMade"
                                                        value="{{ $role->id }}" checked name="roles[]">
                                                    <label class="form-check-label" for="changesMade">
                                                        {{ $role->title }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form><!-- End settings Form -->
                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form method="post" action="{{ route('changePassword') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="currentPassword"
                                            value="{{ $user->password }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                                        @if ($errors->has('newpassword'))
                                            <span style="color: red">{{ $errors->first('newpassword') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="renewpassword" type="password" class="form-control"
                                            id="renewPassword">
                                        @if ($errors->has('renewpassword'))
                                            <span style="color: red">{{ $errors->first('renewpassword') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                                <input type="hidden" name="id" value="{{ $user->id }}">
                            </form><!-- End Change Password Form -->
                        </div>
                    </div><!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom_scripts')
    <script>
        $("#profileImage").click(function(e) {
            $("#imageUpload").click();
        });

        function fasterPreview(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#profileImage').attr('src',
                    window.URL.createObjectURL(uploader.files[0]));
            }
        }

        $("#imageUpload").change(function() {
            fasterPreview(this);
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            var form_data = new FormData();
            form_data.append("imageUpload", this.files[0]);
            form_data.append('_token', CSRF_TOKEN);
            $.ajax({
                type: 'POST',
                url: '{{ route('updateProfile') }}',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    displayMessage("Profile Pic Uploaded Successfully");
                }
            });
        });

        function displayMessage(message) {
            toastr.success(message, 'Pic');
        }
    </script>
@endpush
