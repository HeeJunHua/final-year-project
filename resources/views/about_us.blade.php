<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Page</title>
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
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .card {
            height: 100%;
            border: none;
        }

        .card-img-top {
            object-fit: cover;
            height: 200px;
            /* Adjust the height as needed */
        }

        .card-body {
            text-align: center;
        }

        .featurette {
            margin-top: 40px;
        }

        .featurette-heading {
            font-size: 2rem;
        }

        .lead {
            font-size: 1.25rem;
        }

        .featurette-image {
            object-fit: cover;
            height: 400px;
            /* Adjust the height as needed */
            width: 100%;
        }
    </style>
</head>

<body>
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Fundraising & Food Waste Reduction About us</h1>
            <p class="lead text-muted">Embark on a journey with us to create a positive global impact. Join our mission to combat food waste and contribute to meaningful fundraising initiatives, ensuring that no one goes to bed hungry.</p>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="{{ asset('asset/about_us_1_fundraise.jpg') }}"
                            alt="Fundraising Image">
                        <div class="card-body">
                            <p class="card-text">Discover the power of collective fundraising. Support causes that
                                matter
                                to you and contribute to positive change.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="{{ asset('asset/about_us_1_food_waste.jpg') }}"
                            alt="Food Waste Image">
                        <div class="card-body">
                            <p class="card-text">Learn how we address the critical issue of food waste. Our innovative
                                solutions aim to reduce waste and create a sustainable future.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="{{ asset('asset/about_us_1_fundraise_food_waste.jpg') }}"
                            alt="Fundraising with Food Waste Image">
                        <div class="card-body">
                            <p class="card-text">Combine the power of fundraising with the impact of reducing food
                                waste.
                                See how we integrate both to create a meaningful and lasting difference.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="featurette-divider">
    <!-- First Featurette -->
    <div class="row featurette">
        <div class="col-md-5 offset-md-1 d-flex align-items-center">
            <div>
                <h2 class="featurette-heading fw-normal lh-1">Empowering Fundraising. <span
                        class="text-body-secondary">Supporting Causes.</span></h2>
                <p class="lead">Our platform allows individuals and organizations to initiate and participate in
                    fundraising
                    campaigns, supporting a wide range of causes that make a positive impact in our communities.</p>
            </div>
        </div>
        <div class="col-md-5 offset-md-1">
            <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image mx-auto rounded card-image-bot"
                src="{{ asset('asset/about_us_2_fundraise.jpg') }}" alt="Empowering Fundraising Image">
        </div>
    </div>

    <hr class="featurette-divider">

    <!-- Second Featurette -->
    <div class="row featurette">
        <div class="col-md-5 offset-md-1">
            <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image mx-auto rounded card-image-bot"
                src="{{ asset('asset/about_us_2_food_waste.jpg') }}" alt="Tackling Food Waste Image">
        </div>
        <div class="col-md-5 offset-md-1 d-flex align-items-center">
            <div>
                <h2 class="featurette-heading fw-normal lh-1">Tackling Food Waste. <span
                        class="text-body-secondary">Creating Sustainability.</span></h2>
                <p class="lead">Learn about our initiatives to reduce food waste. We employ innovative strategies and
                    community engagement to create a sustainable and compassionate future for all.</p>
            </div>
        </div>
    </div>

    <hr class="featurette-divider">

    <!-- Third Featurette -->
    <div class="row featurette p-4">
        <div class="col-md-5 offset-md-1 d-flex align-items-center">
            <div>
                <h2 class="featurette-heading fw-normal lh-1">Combining Forces. <span class="text-body-secondary">Making
                        a Lasting Impact.</span></h2>
                <p class="lead">Discover how we integrate fundraising efforts with our mission to reduce food waste.
                    Together,
                    we can create a meaningful and lasting impact on the world.</p>
            </div>
        </div>
        <div class="col-md-5 offset-md-1">
            <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image mx-auto rounded card-image-bot"
                src="{{ asset('asset/about_us_2_fundraise_food_waste.jpg') }}" alt="Combining Forces Image">
        </div>
    </div>
    
    <hr class="featurette-divider">
    <!-- Bootstrap JS -->
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>
<footer>
    @include('bot_nav_bar')
</footer>
</html>
