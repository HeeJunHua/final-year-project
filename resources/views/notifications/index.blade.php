@extends('layouts.app')

@section('title')<title>Notification</title>@endsection

@section('content')
    <div class="container my-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Sort Notifications</h5>
                <form id="sortForm">
                    <div class="form-group">
                        <label for="sortNotifications">Sort By:</label>
                        <select class="form-control" id="sortNotifications" name="sort">
                            <option value="newest" selected>Newest First</option>
                            <option value="oldest">Oldest First</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <h1 class="mb-4">Notifications</h1>


        @if ($getAllUserNotifications->isEmpty())
            <div class="alert alert-info" role="alert">
                No notifications to display.
            </div>
        @else
            <div class="list-group my-4">
                @foreach($getAllUserNotifications as $notification)
                    <div class="card mb-3 {{ $notification->notification_read ? 'alert-info' : 'alert-warning' }}">
                        <div class="card-body">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">
                                    <i class="fa-regular fa-bell notificationIcon"></i>
                                    {{ $notification->notification_title }}
                                </h5>
                                <small>
                                    <i class="fa-regular fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <p class="mb-1">{{ $notification->notification_content }}</p>
                            <small>
                                @unless($notification->notification_read)
                                    (<a href="{{ route('notifications.mark-as-read', $notification->id) }}">
                                        <i class="far fa-check-circle mr-1"></i>
                                        Mark as Read
                                    </a>)
                                @endunless
                            </small>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .list-group-item.unread {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .list-group-item.read {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .notificationIcon {
            color: #0c5460;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
    setTimeout(function () {
        $('#successAlert').fadeOut();
    }, 3000); // Adjust the duration as needed

    // Set the default value to 'newest' if no 'sort' parameter is present
    var selectedSort = new URLSearchParams(window.location.search).get('sort') || 'newest';

    // Set the selected option in the dropdown based on the 'sort' value
    $('#sortNotifications').val(selectedSort);

    // Listen for changes in the select input
    $('#sortNotifications').change(function () {
        // Get the selected value
        var selectedSort = $(this).val();

        // Submit the form to apply sorting
        $('#sortForm').submit();
    });
});

    </script>

@endsection
