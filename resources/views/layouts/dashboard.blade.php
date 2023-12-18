<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

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
        @yield('style');
    </style>
    
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Fundraising & Food Waste Reduction</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <!-- DUMMY -->
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('fundraise_home_page')}}" class="brand-link">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">F & F</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('storage/profile_photos/' . auth()->user()->user_photo) }}"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ route('user.profile')}}" class="d-block">{{ auth()->user()->username }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('fundraise_home_page')}}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('user.dashboard')}}"
                                class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                            <a href="{{ route('user.profile')}}"
                                class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ request()->routeIs('event.history') || request()->routeIs('event.redeem') || request()->routeIs('food.donation.history')  || request()->routeIs('event.redistribution.history.status') || request()->routeIs('event.redistribution.history') || request()->routeIs('food.donation.history.status') ? 'menu-open' : ''}}">
                            <a href="#"
                                class="nav-link {{ request()->routeIs('event.history') || request()->routeIs('food.donation.history') || request()->routeIs('event.redistribution.history')  || request()->routeIs('event.redistribution.history.status') || request()->routeIs('food.donation.history.status') || request()->routeIs('event.redeem') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>Donor<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('event.history')}}"
                                        class="nav-link {{ request()->routeIs('event.history') ? 'active' : '' }}">
                                        <i class="fas fa-history nav-icon"></i>
                                        <p>Donation History</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('food.donation.history')}}"
                                        class="nav-link {{ request()->routeIs('food.donation.history') || request()->routeIs('food.donation.history.status') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-hamburger"></i>
                                        <p>Food Donation History</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('event.redistribution.history')}}"
                                        class="nav-link {{ request()->routeIs('event.redistribution.history')  || request()->routeIs('event.redistribution.history.status') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-star"></i>
                                        <p>Redistribution History</p>
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="{{ route('event.redeem', ['status'=>'Ongoing'])}}"
                                        class="nav-link {{ request()->routeIs('event.redeem') ? 'active' : '' }}">
                                        <i class="fas fa-gifts nav-icon"></i>
                                        <p>Points Redemption</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ request()->routeIs('event.volunteer') ? 'active' : '' }}">
                            <a href="{{ route('event.volunteer', ['type' => 'myevent'])}}"
                                class="nav-link {{ request()->routeIs('event.volunteer') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Volunteer</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('event.reportvolunteer') ? 'active' : '' }}">
                            <a href="{{ route('event.reportvolunteer')}}"
                                class="nav-link {{ request()->routeIs('event.reportvolunteer') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file"></i>
                                <p>Volunteer Report</p>
                            </a>
                        </li>
                        @if(auth()->user()->user_role=="admin")
                        <li class="nav-item {{ request()->routeIs('event.report') ? 'menu-open' : '' }}">
                            @else
                        <li
                            class="nav-item {{ request()->routeIs('event.index') || request()->routeIs('event.report') ? 'menu-open' : '' }}">
                            @endif

                            @if(auth()->user()->user_role=="admin")
                            <a href="#" class="nav-link {{ request()->routeIs('event.report') ? 'active' : '' }}">
                                @else
                                <a href="#"
                                    class="nav-link {{ request()->routeIs('event.index') || request()->routeIs('event.report') ? 'active' : '' }}">
                                    @endif
                                    <i class="nav-icon fas fa-donate"></i>
                                    <p>Fundraiser<i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if(auth()->user()->user_role!="admin")
                                    <li class="nav-item">
                                        <a href="{{ route('event.index')}}"
                                            class="nav-link {{ request()->routeIs('event.index') ? 'active' : '' }}">
                                            <i class="fas fa-calendar-week nav-icon"></i>
                                            <p>Fundraising Event</p>
                                        </a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a href="{{ route('event.report')}}"
                                            class="nav-link {{ request()->routeIs('event.report') ? 'active' : '' }}">
                                            <i class="fas fa-file nav-icon"></i>
                                            <p>Report</p>
                                        </a>
                                    </li>
                                </ul>
                        </li>
                        @if(auth()->user()->user_role=="admin")
                        <li class="nav-item {{ request()->routeIs('admin.dashboard.users') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard.users')}}"
                                class="nav-link {{ request()->routeIs('admin.dashboard.users') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>User Management</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('event.index') ? 'active' : '' }}">
                            <a href="{{ route('event.index')}}"
                                class="nav-link {{ request()->routeIs('event.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>Event Management</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('voucher.index') ? 'active' : '' }}">
                            <a href="{{ route('voucher.index')}}"
                                class="nav-link {{ request()->routeIs('voucher.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-percent"></i>
                                <p>Voucher Management</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('category.index') ? 'active' : '' }}">
                            <a href="{{ route('category.index')}}"
                                class="nav-link {{ request()->routeIs('category.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Category Management</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.dashboard.food.donation.list') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard.food.donation.list')}}"
                                class="nav-link {{ request()->routeIs('admin.dashboard.food.donation.list') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-utensils"></i>
                                <p>Food Donation Management</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.eventRedistributionList') ? 'active' : '' }}">
                            <a href="{{ route('admin.eventRedistributionList')}}"
                                class="nav-link {{ request()->routeIs('admin.eventRedistributionList') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Event Redistirbution Management</p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link" style="border: none; background: none;">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </form>                            
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page_title')</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible" id="errorAlert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error</h5> {{ session('error') }}
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success alert-dismissible" id="successAlert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success</h5> {{ session('success') }}
                </div>
                @endif

                @yield('content')
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- Default to the left -->
            <strong>Fundraising & Food Waste Reduction</strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- Bootstrap 4 -->
    <script src="{{ asset('theme/v1/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('theme/v1/dist/js/adminlte.min.js') }}"></script>
    <!-- Custom Script -->
    <script src="{{ asset('js/script.js') }}"></script>

    @yield('scripts');
</body>

</html>