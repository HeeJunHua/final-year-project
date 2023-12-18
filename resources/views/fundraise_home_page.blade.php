<!DOCTYPE html>
<html>

<head>
    <title>Fundraising & Food Waste Reduction Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    @include('top_nav_bar')
    <link rel="stylesheet" href="{{ asset('css/home_page.css')}}">
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




    @if (\Request::is('/'))
        <div id="carouselExample" class="carousel slide mb-6" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="overlay"></div> <!-- Dark overlay -->
                    <img src="{{ asset('team-fundraising-motivation.jpg') }}"
                        class="d-block w-100 h-100 object-fit-cover transparent-img" alt="Fundraising Slide">
                    <div class="carousel-caption d-none d-md-block text-light">
                        <h2>Fundraise for a Cause</h2>
                        <p>Join hands in our mission to make a difference. Your support fuels positive change in the
                            community.</p>
                        {{-- create the button task --}}
                        <button class="btn btn-primary mb-4"
                            onclick="window.location='{{ route('event.allevent', 'Ongoing') }}'">Get Involved</button>
                    </div>
                </div>
                <!-- Second Carousel Item -->
                <div class="carousel-item">
                    <div class="overlay"></div> <!-- Dark overlay -->
                    <img src="{{ asset('food_waste_reduction_images.png') }}"
                        class="d-block w-100 h-100 object-fit-cover transparent-img" alt="Food Waste Reduction Slide">
                    <div class="carousel-caption d-none d-md-block text-light">
                        <h2>Reduce Food Waste</h2>
                        <p>Contribute to our food waste reduction initiative. Every donation brings us a step closer to
                            a sustainable future.</p>
                        <button class="btn btn-success mb-4"
                            onclick="window.location='{{ route('food.donation') }}'">Donate Now</button>
                    </div>
                </div>
                <!-- Third Carousel Item -->
                <div class="carousel-item">
                    <div class="overlay"></div> <!-- Dark overlay -->
                    <img src="{{ asset('home_page_fundraising_banner.png') }}"
                        class="d-block w-100 h-100 object-fit-cover transparent-img" alt="Get Involved Slide">
                    <div class="carousel-caption d-none d-md-block text-light">
                        <h2>Get Involved Today</h2>
                        <p>Explore opportunities to volunteer, donate, or participate in events. Together, we can
                            achieve more.</p>
                        <button class="btn btn-warning mb-4" onclick="window.location='{{ route('about-us') }}'">Learn
                            More</button>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselExample" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselExample" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselExample" data-bs-slide-to="2"></li>
            </ol>
        </div>




        <div class="col-xxl-8 px-4 py-5 mx-auto">
            <!-- Food Donation Section -->
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <img src="{{ asset('asset/home_page_2_food_waste.jpg') }}" class="d-block mx-lg-auto img-fluid mb-4"
                        alt="Food Donation" width="700" height="500" loading="lazy">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Make a Difference with Food Donation</h1>
                    <p class="lead">Join us in the mission to combat hunger and reduce food waste by contributing to
                        our food donation initiative. Bootstrap your impact with the world's most popular front-end
                        toolkit, offering a responsive design and powerful features.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button type="button" class="btn btn-primary btn-lg px-4 me-md-2" 
                        onclick="window.location='{{ route('food.donation') }}'">Get Involved</button>
                    </div>
                </div>
            </div>

            <!-- Event Redistribution Section -->
            <div class="row align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <img src="{{ asset('asset/home_page_2_event_redistribution.jpg') }}"
                        class="d-block mx-lg-auto img-fluid mb-4" alt="Event Redistribution" width="700"
                        height="500" loading="lazy">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Empower Communities with Event
                        Redistribution</h1>
                    <p class="lead">Organize and participate in events that promote the fair distribution of
                        resources. Bootstrap your community engagement with our responsive design and user-friendly
                        features, ensuring seamless event planning and execution.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button type="button" class="btn btn-success btn-lg px-4 me-md-2" 
                        onclick="window.location='{{ route('redistribution.page') }}'">Plan an Event</button>
                    </div>
                </div>
            </div>

            <!-- Inventory Simulation Section -->
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <img src="{{ asset('asset/home_page_2_inventory_simulation.jpg') }}"
                        class="d-block mx-lg-auto img-fluid mb-4" alt="Inventory Simulation" width="700"
                        height="500" loading="lazy">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Optimize Resources with Inventory
                        Simulation</h1>
                    <p class="lead">Take control of your inventory and optimize resource allocation through our
                        innovative simulation platform. Bootstrap your inventory management with responsive design and
                        intuitive features, ensuring efficient and sustainable practices.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button type="button" class="btn btn-warning btn-lg px-4 me-md-2"
                        onclick="window.location='{{ route('inventory.index') }}'">Explore Simulation</button>
                    </div>
                </div>
            </div>
        </div>
    @endif












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
    $(document).ready(function() {
        setTimeout(function() {
            $('#success').fadeOut();
        }, 3000); // Adjust the duration as needed
    });
    $(document).ready(function() {
        setTimeout(function() {
            $('#successAlert').fadeOut();
        }, 3000); // Adjust the duration as needed
    });
    $(document).ready(function() {
        setTimeout(function() {
            $('#error').fadeOut();
        }, 3000); // Adjust the duration as needed
    });
</script>
