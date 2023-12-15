@section('title')
My Profile
@endsection

@section('page_title')
My Profile
@endsection

@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Profile</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('edit.user.update') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- To different between dashboard and home -->
                        <input type="hidden" name="is_dashboard" value="1">

                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('storage/profile_photos/' . auth()->user()->user_photo) }}"
                                    alt="User profile picture" id="edit-picture">
                                <div onclick="triggerFileInput()"><b><i class="fas fa-pencil-alt"></i>
                                        Edit</div></b>
                                @error('user_photo')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="file" id="edit-picture-button" name="user_photo" onchange="displaySelectedFile(this)"
                                hidden accept="image/*">
                        </div>

                        <table class="table table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <th>First Name</th>
                                    <td>
                                        <input id="first_name" type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                            required>

                                        @error('first_name')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td>
                                        <input id="last_name" type="text"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                        @error('last_name')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Contact Number</th>
                                    <td>
                                        <input id="contact_number" type="text"
                                            class="form-control @error('contact_number') is-invalid @enderror"
                                            name="contact_number"
                                            value="{{ old('contact_number', $user->contact_number) }}" required>
                                        @error('contact_number')
                                        <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="submit" class="btn btn-block btn-success btn-lg">
                                            Update Profile
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection