<!-- resources/views/layouts/fundraise_layout.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    @include('top_nav_bar')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('theme/v1/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('theme/v1/dist/css/adminlte.min.css') }}">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('theme/v1/plugins/jquery/jquery.min.js') }}"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .content {
            min-height: calc(100vh - 60px);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
        }

        .info-icon {
            margin-left: 5px;
            color: #007bff;
            /* Bootstrap's primary color */
            cursor: pointer;
        }

    </style>
    @yield('style')
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div class="content">
        @yield('content')
    </div>

    @include('bot_nav_bar')
    
    @yield('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Set a timer to fade out the alert after 3 seconds (3000 milliseconds)
        $(document).ready(function () {
            setTimeout(function () {
                $('#success').fadeOut();
            }, 3000); // Adjust the duration as needed
        });
        $(document).ready(function () {
            setTimeout(function () {
                $('#successAlert').fadeOut();
            }, 3000); // Adjust the duration as needed
        });
        $(document).ready(function () {
            setTimeout(function () {
                $('#error').fadeOut();
            }, 3000); // Adjust the duration as needed
        });
    </script>

    <!-- AdminLTE App -->
    <script src="{{ asset('theme/v1/dist/js/adminlte.min.js') }}"></script>
    <!-- Custom Script -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>