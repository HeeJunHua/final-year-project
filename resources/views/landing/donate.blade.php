<!DOCTYPE html>
<html>

<head>
    <title>Fundraising Home</title>
    @include('top_nav_bar')
    <style>
        .content {
            position: relative;
            min-height: 630px;
            overflow: hidden;
        }

        .content-background {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('nonprofits-charitable-organizations.png') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            animation: slideIn 2s forwards; /* Slide in the content once */
            opacity: 0.8;
        }

        @keyframes slideIn {
            from { left: -100%; }
            to { left: 0; }
        }

        .content-text {
            position: relative;
            z-index: 1;
            padding: 20px;
            color: #000000;
        }

        /* Add styles for the donate buttons */
        .donate-buttons {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }

        .donate-food-button {
            background-color: #7b28e1;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            cursor: pointer;
        }

        .donate-funds-button {
            background-color: #88e868;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    
    @if (session('success'))
        <div class="alert alert-success"  style="margin-bottom: 0px;" id="successAlert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger"  style="margin-bottom: 0px;" id="loginToContinue">
            {{ session('error') }}
        </div>
    @endif

    <div class="content">
        <div class="content-background"></div>

        <!-- Donate buttons -->
        <div class="donate-buttons">
            <button class="donate-food-button ">Donate Foods</button>
            <button class="donate-funds-button">Donate Funds</button>
        </div>
    </div>

    <!-- fund raise start -->
    @include('landing/donate_content')
    <!-- fund raise end -->
</body>

<footer>
    @include('bot_nav_bar')
</footer>

</html>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Set a timer to fade out the alert after 3 seconds (3000 milliseconds)
    $(document).ready(function() {
        setTimeout(function() {
            $('#successAlert').fadeOut();
        }, 3000); // Adjust the duration as needed
    });
    $(document).ready(function() {
        setTimeout(function() {
            $('#loginToContinue').fadeOut();
        }, 3000); // Adjust the duration as needed
    });
</script>