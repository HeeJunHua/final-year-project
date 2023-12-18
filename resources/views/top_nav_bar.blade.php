<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .profile-picture img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .logo {
        max-width: 70px;
        /* Adjust the maximum width as needed */
    }

    /* Add this style to set the background color of the top navigation bar */
    .top-nav {
        background-color: #333333;
        /* Choose the color you prefer */
    }

    /* Optionally, you can also add styles to change the text color, etc. */
    .top-nav .navbar-nav .nav-link {
        color: #ffffff;
        /* Set the text color to white */
    }

    .hide-dropdown-arrow::after {
        display: none !important;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark top-nav p-0">
    <div class="container-fluid">
        <a class="navbar-brand m-2" href="#">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
        </a>

        <!-- Toggle Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse justify-content-center order-1" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link mx-2" href="{{ route('fundraise_home_page')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2" href="{{ route('about-us')}}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2" href="{{ route('faqs')}}">FAQs</a>
                </li>
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" id="fundraisingDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Fundraise
                    </a>
                    <div class="dropdown-menu" aria-labelledby="fundraisingDropdown">
                        <a class="dropdown-item" href="{{ route('event.allevent', 'Ongoing')}}">Events</a>
                        <a class="dropdown-item" href="{{ route('event.volunteer', ['type' => 'myevent']) }}">Volunteer</a>
                        <a class="dropdown-item" href="{{ route('event.redeem', ['status'=>'Ongoing'])}}">Points Redemption</a>
                    </div>
                </li>
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" id="foodDonationDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Food Donation
                    </a>
                    <div class="dropdown-menu" aria-labelledby="foodDonationDropdown">
                        <a class="dropdown-item" href="{{ route('food.donation') }}">Donate Food</a>
                        <a class="dropdown-item" href="{{ route('redistribution.page') }}">Food Distribution</a>
                        <a class="dropdown-item" href="{{ route('inventory.index') }}">Inventory Simulation</a>
                    </div>
                </li>
            </ul>
        </div>

        <!-- User Profile and Notifications -->
        <div class="order-4">
            <ul class="navbar-nav flex-row">
                @if (Auth::check())

                    <li class="nav-item dropdown d-flex align-items-center notification-icon">
                        <a class="nav-link dropdown-toggle hide-dropdown-arrow" href="#" id="notificationDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span
                                class="badge badge-danger d-md-none d-lg-inline">{{ $userNotifications->where('notification_read', false)->count() }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
                            @forelse($userNotifications->take(5) as $notification)
                                <a class="dropdown-item mark-as-read"
                                    href="{{ route('notifications.mark-as-read', ['id' => $notification->id]) }}">
                                    <strong>{{ $notification->notification_title }}</strong>
                                    <br>
                                    {{ $notification->notification_content }}
                                    <br>
                                    <small>
                                        <i class="far fa-clock"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </a>
                                <div class="dropdown-divider"></div>
                            @empty
                                <a class="dropdown-item" href="#">No new notifications</a>
                            @endforelse

                            @if ($userNotifications->count() >= 5)
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('mark-all-as-read') }}">
                                    Mark All as Read
                                </a>
                            @endif
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="rounded-circle overflow-hidden profile-picture">
                                <img src="{{ asset('storage/profile_photos/' . auth()->user()->user_photo) }}"
                                    alt="Profile Picture" class="img-fluid">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a>
                            <a class="dropdown-item" href="{{ route('user.profile') }}">My Profile</a>
                            <a class="dropdown-item" href="{{ route('notifications.index') }}">Notification</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-dark dropdown-item"
                                    style="border: none; background: none;">Logout</button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle hide-dropdown-arrow" href="#" id="userDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="rounded-circle overflow-hidden profile-picture profile-picture">
                                <i class="bi bi-gear-fill"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('register') }}"><i class="fa fa-user-plus"></i>
                                Register</a>
                            <a class="dropdown-item" href="{{ route('login.form') }}"><i class="fa fa-sign-in"></i>
                                Login</a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
