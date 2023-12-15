<style>
    .top-nav {
        background-color: #333;
        color: white;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .top-nav .search-bar input {
        padding: 5px;
        margin-right: 10px;
    }

    .top-nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .top-nav ul li {
        margin-left: 10px;
    }

    .top-nav ul li:first-child {
        margin-left: 0;
    }

    .top-nav ul li a {
        color: white;
        text-decoration: none;
    }

    .profile-picture img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .fa-bell {
        color: #f0f0f0;
        /* Change this to the color you want */
    }

    .hide-dropdown-arrow::after {
        display: none !important;
    }

    .top-nav-bar {
        min-height: 80px;
    }

</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-0 top-nav-bar">
    <div class="container-fluid">
        <!-- Search Bar -->
        <div class="d-flex order-2">
            <input class="form-control me-2 mr-3" type="search" placeholder="Search..." aria-label="Search">
            <button class="btn btn-outline-light">Search</button>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <!-- Navigation Links -->
        <div class="collapse navbar-collapse justify-content-center order-3" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item mx-4">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link" href="/about">About Us</a>
                </li>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link" href="/">FAQs</a>
                </li>
                <li class="nav-item dropdown mx-4">
                    <a class="nav-link dropdown-toggle" href="#" id="fundraisingDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Fundraise
                    </a>
                    <div class="dropdown-menu" aria-labelledby="fundraisingDropdown">
                        <a class="dropdown-item" href="#">Fundraise</a>
                        <a class="dropdown-item" href="#">Food Donation</a>
                        <a class="dropdown-item" href="#">Food Redistribution</a>
                        <!-- Add more fundraising-related sub-menu items as needed -->
                    </div>
                </li>
                <li class="nav-item dropdown mx-4">
                    <a class="nav-link dropdown-toggle" href="#" id="foodDonationDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria expanded="false">
                        Food Donation
                    </a>
                    <div class="dropdown-menu" aria-labelledby="foodDonationDropdown">
                        <a class="dropdown-item" href="{{ route('food.donation')}}">Donate Food</a>
                        <a class="dropdown-item" href="{{ route('redistribution.page')}}">Food Distribution</a>
                        <a class="dropdown-item" href="{{ route('inventory.index') }}">Inventory Simulation</a>
                        <!-- Add more food donation-related sub-menu items as needed -->
                    </div>
                </li>
            </ul>
        </div>

        <div class="order-4" id="navbarNav">
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link dropdown-toggle hide-dropdown-arrow" href="#" id="notificationDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-danger">2</span>
                        </a>
                
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
                            <a class="dropdown-item" href="#">notification 1</a>
                            <a class="dropdown-item" href="#">notification 2</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="rounded-circle overflow-hidden profile-picture">
                                <img src="{{ asset('storage/profile_photos/' . auth()->user()->user_photo) }}" alt="Profile Picture" class="img-fluid">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a>
                            <a class="dropdown-item" href="{{ route('user.profile') }}">My Profile</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-dark dropdown-item" style="border: none; background: none;">Logout</button>
                            </form>
                        </div>
                    </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle hide-dropdown-arrow" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="rounded-circle overflow-hidden profile-picture profile-picture">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Register</a>
                        <a class="dropdown-item" href="{{ route('login.form') }}"><i class="fa fa-sign-in"></i> Login</a>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
