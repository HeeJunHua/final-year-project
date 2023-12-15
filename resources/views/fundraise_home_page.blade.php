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

        /* Set fixed height for carousel images */
        #carouselExample .carousel-inner img {
            width: 100%; /* Make the image fill its container */
            height: 615px;
            object-fit: cover;
        }

        /* Customize navigation arrows */
        #carouselExample .carousel-control-prev,
        #carouselExample .carousel-control-next {
            width: 5%;
        }

        /* Customize navigation indicators (dots) */
        #carouselExample .carousel-indicators {
            position: absolute;
            bottom: 15px;
            left: 35%;
            transform: translateX(-50%);
            display: flex;
            list-style: none;
        }

        #carouselExample .carousel-indicators li {
            background-color: #fff;
            border: 2px solid #000; /* Black outer border */
            border-radius: 50%;
            width: 15px;
            height: 15px;
            margin: 0 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        #carouselExample .carousel-indicators li.active {
            background-color: #000;
        }
    </style>
</head>

<body>

    @if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 0px;" id="successAlert">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger" style="margin-bottom: 0px;" id="loginToContinue">
        {{ session('error') }}
    </div>
    @endif

    <div class="content">
        <!-- Bootstrap Carousel -->
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{asset('team-fundraising-motivation.jpg')}}" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="{{asset('food_waste_reduction_images.png')}}" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="{{asset('home_page_fundraising_banner.png')}}" class="d-block w-100" alt="Slide 3">
                </div>
                <!-- Add more carousel items as needed -->
            </div>
            <!-- Navigation arrows -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <!-- Navigation indicators (dots) -->
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselExample" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselExample" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselExample" data-bs-slide-to="2"></li>
                <!-- Add more indicators as needed -->
            </ol>
        </div>

        <!-- Donate buttons -->
        <div class="donate-buttons">
            <button class="donate-food-button ">Donate Foods</button>
            <button class="donate-funds-button">Donate Funds</button>
        </div>
    </div>

    <!-- fund raise start -->
    @include('landing/home')
    <!-- fund raise end -->
</body>

<footer>
    @include('bot_nav_bar')
</footer>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Set a timer to fade out the alert after 3 seconds (3000 milliseconds)
    $(document).ready(function () {
        setTimeout(function () {
            $('#successAlert').fadeOut();
        }, 3000); // Adjust the duration as needed
    });
    $(document).ready(function () {
        setTimeout(function () {
            $('#loginToContinue').fadeOut();
        }, 3000); // Adjust the duration as needed
    });

    // Automatic sliding every 20 seconds
    $('#carouselExample').carousel({
        interval: 20000 // 20 seconds
    });
</script>
