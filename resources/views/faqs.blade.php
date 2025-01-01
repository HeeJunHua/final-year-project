<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequent Asked Question</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        body {
            margin-top: 20px;
        }

        .accordion-style .card {
            background: transparent;
            box-shadow: none;
            margin-bottom: 15px;
            margin-top: 0 !important;
            border: none;
        }

        .accordion-style .card:last-child {
            margin-bottom: 0;
        }

        .accordion-style .card-header {
            border: 0;
            background: none;
            padding: 0;
            border-bottom: none;
        }

        .accordion-style .btn-link {
            color: #ffffff;
            position: relative;
            background: #15395a;
            border: 1px solid #15395a;
            display: block;
            width: 100%;
            font-size: 18px;
            border-radius: 3px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            text-align: left;
            white-space: normal;
            box-shadow: none;
            padding: 15px 55px;
            text-decoration: none;
        }

        .accordion-style .btn-link:hover {
            text-decoration: none;
            background-color: #15395a;
            color: #ffffff;
        }

        .accordion-style .btn-link.collapsed {
            background: #ffffff;
            border: 1px solid #15395a;
            color: #1e2022;
            border-radius: 3px;
        }

        .accordion-style .btn-link.collapsed:after {
            background: none;
            border-radius: 3px;
            content: "+";
            left: 16px;
            right: inherit;
            font-size: 20px;
            font-weight: 600;
            line-height: 26px;
            height: 26px;
            transform: none;
            width: 26px;
            top: 15px;
            text-align: center;
            background-color: #15395a;
            color: #fff;
        }

        .accordion-style .btn-link:after {
            background: #fff;
            border: none;
            border-radius: 3px;
            content: "-";
            left: 16px;
            right: inherit;
            font-size: 20px;
            font-weight: 600;
            height: 26px;
            line-height: 26px;
            transform: none;
            width: 26px;
            top: 15px;
            position: absolute;
            color: #15395a;
            text-align: center;
        }

        .accordion-style .card-body {
            padding: 20px;
            border-top: none;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            border-left: 1px solid #15395a;
            border-right: 1px solid #15395a;
            border-bottom: 1px solid #15395a;
        }

        @media screen and (max-width: 767px) {
            .accordion-style .btn-link {
                padding: 15px 40px 15px 55px;
            }
        }

        @media screen and (max-width: 575px) {
            .accordion-style .btn-link {
                padding: 15px 20px 15px 55px;
            }
        }

        .card-style1 {
            box-shadow: 0px 0px 10px 0px rgb(89 75 128 / 9%);
        }

        .border-0 {
            border: 0 !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
        }

        section {
            padding: 120px 0;
            overflow: hidden;
            background: #fff;
        }

        .mb-2-3,
        .my-2-3 {
            margin-bottom: 2.3rem;
        }

        .section-title {
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .text-primary {
            color: #ceaa4d !important;
        }
    </style>
</head>

<body>
    <section class="bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card card-style1 border-0">
                        <div class="card-body p-4 p-md-5 p-xl-6">
                            <div class="text-center mb-2-3 mb-lg-6">
                                <span class="section-title text-primary">FAQ's</span>
                                <h2 class="h1 mb-0 text-secondary">Frequently Asked Questions</h2>
                            </div>
                            <div id="accordion" class="accordion-style">
                                <!-- Fundraising Section -->
                                <div class="card mb-3">
                                    <div class="card-header" id="fundraisingHeading">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-bs-toggle="collapse"
                                                data-bs-target="#fundraisingCollapse" aria-expanded="true"
                                                aria-controls="fundraisingCollapse"><span
                                                    class="text-theme-secondary me-2">Q.</span> How can I donate funds to
                                                a campaign?</button>
                                        </h5>
                                    </div>
                                    <div id="fundraisingCollapse" class="collapse show" aria-labelledby="fundraisingHeading"
                                        data-bs-parent="#accordion">
                                        <div class="card-body">
                                            Donating funds is simple! Navigate to the campaign you wish to support, click
                                            on the "Donate" button, choose the amount, and follow the provided
                                            instructions to complete your donation securely.
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header" id="volunteerHeading">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#volunteerCollapse" aria-expanded="false"
                                                aria-controls="volunteerCollapse"><span
                                                    class="text-theme-secondary me-2">Q.</span> How can I volunteer for a
                                                cause?</button>
                                        </h5>
                                    </div>
                                    <div id="volunteerCollapse" class="collapse" aria-labelledby="volunteerHeading"
                                        data-bs-parent="#accordion">
                                        <div class="card-body">
                                            Volunteering is a wonderful way to contribute. Visit the "Volunteer"
                                            section, explore available opportunities, and apply for roles that match
                                            your skills and interests.
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header" id="eventsHeading">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#eventsCollapse" aria-expanded="false"
                                                aria-controls="eventsCollapse"><span
                                                    class="text-theme-secondary me-2">Q.</span> How can I create an event
                                                for fundraising?</button>
                                        </h5>
                                    </div>
                                    <div id="eventsCollapse" class="collapse" aria-labelledby="eventsHeading"
                                        data-bs-parent="#accordion">
                                        <div class="card-body">
                                            Organizing an event is exciting! Go to the "Create Event" section, provide
                                            event details, set goals, and share it with your community to maximize
                                            participation and impact.
                                        </div>
                                    </div>
                                </div>

                                <!-- Food Waste Reduction Section -->
                                <div class="card mb-3">
                                    <div class="card-header" id="foodDonationHeading">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#foodDonationCollapse" aria-expanded="false"
                                                aria-controls="foodDonationCollapse"><span
                                                    class="text-theme-secondary me-2">Q.</span> How can I donate surplus
                                                food?</button>
                                        </h5>
                                    </div>
                                    <div id="foodDonationCollapse" class="collapse" aria-labelledby="foodDonationHeading"
                                        data-bs-parent="#accordion">
                                        <div class="card-body">
                                            Donating surplus food is easy! Navigate to the "Food Donation" section, fill
                                            in the details of available food, and connect with local organizations that
                                            can distribute it to those in need.
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header" id="eventRedistributionHeading">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#eventRedistributionCollapse" aria-expanded="false"
                                                aria-controls="eventRedistributionCollapse"><span
                                                    class="text-theme-secondary me-2">Q.</span> How does event
                                                redistribution work?</button>
                                        </h5>
                                    </div>
                                    <div id="eventRedistributionCollapse" class="collapse"
                                        aria-labelledby="eventRedistributionHeading" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            Event redistribution ensures surplus event food reaches those in need.
                                            Organizers can use our platform to coordinate with local partners who can
                                            pick up and distribute excess food from events.
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header" id="inventorySimulationHeading">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#inventorySimulationCollapse" aria-expanded="false"
                                                aria-controls="inventorySimulationCollapse"><span
                                                    class="text-theme-secondary me-2">Q.</span> How can I simulate my
                                                inventory and donate surplus products?</button>
                                        </h5>
                                    </div>
                                    <div id="inventorySimulationCollapse" class="collapse"
                                        aria-labelledby="inventorySimulationHeading" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            Simulating your inventory is a great way to plan donations. Visit the
                                            "Inventory Simulation" section, add details of surplus products, and
                                            explore donation options for items that are in good condition.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<footer>
    @include('bot_nav_bar')
</footer>

</html>
