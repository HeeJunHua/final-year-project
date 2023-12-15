<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@yield('header')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            transition: background-color 0.3s;
        }

        .wrapper {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            background-color: #394150;
            width: 240px;
            overflow-y: auto;
            transition: width 0.3s;
            flex: 0 0 240px;
            color: #fff;
            height: 100%;
            position: fixed;
        }

        .sidebar a {
            padding: 15px;
            text-decoration: none;
            color: #fff;
            display: block;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #4c5364;
        }

        .sidebar .logout {
            margin-top: auto;
            margin-bottom: 20px;
            padding: 15px;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .content {
            padding: 20px;
            flex: 1;
            margin-left: 240px;
            transition: margin-left 0.3s;
        }
    </style>
</head>

<body class="dark-mode">
<div>
        @if (session('success'))
            <div class="alert alert-success"  style="margin-bottom: 0px;" id="successAlert">
                {{ session('success') }}
            </div>
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                  <div class="toast-body">
                    {{ session('success') }}
                 </div>
                  <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
              </div>
        @endif
    </div>
    <!-- Wrapper for the entire content -->
    <div class="wrapper">

        <!-- Sidebar -->
        <div class="sidebar">
            <a href="#">Dashboard</a>
            <a href=" {{ route('admin.dashboard.users')}}">Users</a>
            <a href=" {{ route('admin.dashboard.food.donation.list')}}">Food Donation</a>
            <a href=" {{ route('admin.eventRedistributionList')}}">Event Redistribution</a>
            <a href="#">Reports</a>
            <div class="logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link" style="color: white;">
                        <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i>Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Page content -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JavaScript and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
        $(document).ready(function() {
            setTimeout(function() {
                $('#successAlert').fadeOut();
            }, 3000); // Adjust the duration as needed
        });
    </script>
@yield('javascript')
</body>

</html>
