@extends('layouts.dashboard')

@section('title')
    User Management
@endsection

@section('page_title')
    User Management
@endsection

@section('content')
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        .profile-picture {
            max-width: 100%;
            height: auto;
        }
    </style>

    <div class="card card-warning card-outline">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Filter</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.dashboard.users') }}" method="GET">
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="search">Search:</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search for users..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="sort_by">Sort By:</label>
                                <select name="sort_by" class="form-control">
                                    <option value="username" {{ request('sort_by') == 'username' ? 'selected' : '' }}>Username
                                    </option>
                                    <option value="first_name"
                                        {{ request('sort_by') == 'first_name' ? 'selected' : '' }}>First Name</option>
                                    <option value="last_name"
                                        {{ request('sort_by') == 'last_name' ? 'selected' : '' }}>Last Name</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Profile Picture</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <img src="{{ asset('storage/profile_photos/' . $user->user_photo) }}"
                                    alt="Profile Picture" class="img-thumbnail profile-picture" width="50">
                            </td>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->contact_number }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm view-btn"
                                    data-target="#viewModal{{ $user->id }}" data-toggle="modal"><i
                                        class="fas fa-eye"></i> View</button>
                                <button type="button" class="btn btn-warning btn-sm edit-btn"
                                    data-target="#editModal{{ $user->id }}" data-toggle="modal"><i
                                        class="fas fa-edit"></i> Edit</button>
                                <form action="{{ route('admin.users.delete') }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- View Modal for User {{ $user->id }} -->
                        <div class="modal fade" id="viewModal{{ $user->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="viewModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewModalLabel">User Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/profile_photos/' . $user->user_photo) }}"
                                                alt="Profile Picture" class="img-thumbnail profile-picture" width="300">
                                        </div>
                                        <div class="mb-3">
                                            <strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Email:</strong> {{ $user->email }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Contact Number:</strong> {{ $user->contact_number }}
                                        </div>
                                        <!-- Add other fields as needed -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal for User {{ $user->id }} -->
                        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.users.edit') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                        
                                            <!-- Error Messages -->
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                        
                                            <div class="mb-3 text-center">
                                                <!-- Profile Photo Input -->
                                                <input type="file" id="editProfilePhoto{{ $user->id }}" name="user_photo" class="d-none profile-photo-input" data-preview-id="previewProfilePhoto{{ $user->id }}" />
                                                <!-- Profile Photo Preview with Tooltip -->
                                                <label for="editProfilePhoto{{ $user->id }}" class="mb-0 clickable-label" data-toggle="tooltip" data-placement="bottom" title="Click to change profile picture">
                                                    <img id="previewProfilePhoto{{ $user->id }}" src="{{ asset('storage/profile_photos/' . $user->user_photo) }}"
                                                        alt="Profile Picture" class="img-thumbnail profile-picture" width="100">
                                                </label>
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="editFirstName" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="editFirstName" name="first_name"
                                                    value="{{ $user->first_name }}" required>
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="editLastName" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="editLastName" name="last_name"
                                                    value="{{ $user->last_name }}" required>
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="editEmail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="editEmail" name="email"
                                                    value="{{ $user->email }}" required>
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="editContactNumber" class="form-label">Contact Number</label>
                                                <input type="text" class="form-control" id="editContactNumber" name="contact_number"
                                                    value="{{ $user->contact_number }}" required>
                                            </div>
                        
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Add event listeners for view buttons
    document.querySelectorAll('.view-btn').forEach(function (viewBtn) {
        viewBtn.addEventListener('click', function () {
            $($(this).data('target')).modal('show');
        });
    });

    // Add event listeners for edit buttons
    document.querySelectorAll('.edit-btn').forEach(function (editBtn) {
        editBtn.addEventListener('click', function () {
            $($(this).data('target')).modal('show');
        });
    });

    // Add event listener for close button in both modals
    document.querySelectorAll('[data-dismiss="modal"]').forEach(function (closeBtn) {
        closeBtn.addEventListener('click', function () {
            $(this).closest('.modal').modal('hide');
        });
    });

    document.querySelectorAll('.profile-photo-input').forEach(function (photoInput) {
        photoInput.addEventListener('change', function () {
            var previewId = $(this).data('previewId');
            updateProfilePicture(this, previewId);
        });
    });
});

$(document).ready(function () {
    // Initialize Bootstrap tooltips
    $('[data-toggle="tooltip"]').tooltip();
});

// Function to update profile picture preview when a new file is selected
function updateProfilePicture(input, previewId) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#' + previewId).attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);

    // Optionally, you can submit the form automatically after selecting a file
    // Uncomment the following line if you want to submit the form immediately
    // input.closest('form').submit();
}

    </script>
@endsection
