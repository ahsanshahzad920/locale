<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('/assets') }}/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/assets') }}/css/animate.css">

    <link rel="stylesheet" href="{{ url('/assets') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ url('/assets') }}/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ url('/assets') }}/css/magnific-popup.css">

    <link rel="stylesheet" href="{{ url('/assets') }}/css/aos.css">

    <link rel="stylesheet" href="{{ url('/assets') }}/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ url('/assets') }}/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="{{ url('/assets') }}/css/jquery.timepicker.css">


    <link rel="stylesheet" href="{{ url('/assets') }}/css/flaticon.css">
    <link rel="stylesheet" href="{{ url('/assets') }}/css/icomoon.css">
    <link rel="stylesheet" href="{{ url('/assets') }}/css/style.css">
    <style>
        /* .collapse{
        max-height: 60vh;
        overflow-y: scroll
      } */

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{ url('assets') }}/js/jquery.min.js"></script>
</head>


<!-- END nav -->

<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark fixed-top " id="ftco-navbar">
        <div class="container-fluid px-md-4	">
            <a class="navbar-brand" href="{{ url('/') }}">{{ env('APP_NAME') }} @auth-
                    {{ strtoupper(Auth::user()->role) . ' App' }}@endauth
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                    aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="oi oi-menu"></span> Menu
                </button>

                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
                        <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
                        @auth
                            @if (Auth::user()->role == 'client')
                                <li class="nav-item"> <a href="{{ url('user/projects') }}" class="nav-link"> My
                                        Projects</a></li>
                            @endif

                            @if (Auth::user()->role == 'teamlead')
                                <li class="nav-item"> <a href="{{ url('teamlead/projects') }}" class="nav-link">
                                        Projects </a></li>
                            @endif



                            @if (Auth::user()->role == 'admin')
                                <li class="nav-item"> <a href="{{ url('admin/teamleads/index') }}"
                                        class="nav-link"> My Team Leads</a></li>
                                <li class="nav-item"> <a href="{{ url('admin/inbox') }}" class="nav-link">
                                        Inbox</a></li>
                            @endif


                            @if (Auth::user()->role == 'client')
                                <li class="nav-item cta mr-md-1"><a href="{{ url('user/project') }}"
                                        class="nav-link">Post a Job</a></li>
                            @endif


                        @endauth


                        @guest
                            <li class="nav-item"><a class="nav-link"
                                    href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li class="nav-item "><a class="nav-link"
                                    href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item mr-2 dropdown">
                                <a id="navbarDropdownN" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <span class="dropdown-toolbar-title">Notifications (<span
                                            class="notif-count">0</span>)</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownN">

                                    <ul class="nav navbar-nav">
                                        <li class="dropdown dropdown-notifications">
                                            <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
                                                <i data-count="0" class="glyphicon glyphicon-bell notification-icon"></i>
                                            </a>

                                            <div class="dropdown-container">
                                                <div class="dropdown-toolbar">
                                                    <div class="dropdown-toolbar-actions">
                                                    </div>
                                                </div>
                                                <ul class="dropdown-menu">
                                                </ul>
                                                <div class="dropdown-footer text-center">
                                                </div>
                                            </div>
                                        </li>

                                    </ul>


                                </div>
                            </li>


                            <li class="nav-item mr-2 dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                        @endguest

                    </ul>
                </div>
            </div>
        </nav>
        <div id="app" class="w-100">


            <main class="">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('dagner'))
                    <div class="alert alert-danger">
                        {{ Session::get('danger') }}
                    </div>
                @endif

                @yield('contentHome')

                <div style="padding-top: 80px !important">
                    @yield('content')
                </div>

            </main>
        </div>

        <footer class="ftco-footer ftco-bg-dark ftco-section">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md">
                        <div class="ftco-footer-widget mb-4">
                            <h2 class="ftco-heading-2">Skillhunt Jobboard</h2>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                there live the blind texts.</p>
                            <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="ftco-footer-widget mb-4">
                            <h2 class="ftco-heading-2">Employers</h2>
                            <ul class="list-unstyled">
                                <li><a href="#" class="pb-1 d-block">Browse Candidates</a></li>
                                <li><a href="#" class="pb-1 d-block">Post a Job</a></li>
                                <li><a href="#" class="pb-1 d-block">Employer Listing</a></li>
                                <li><a href="#" class="pb-1 d-block">Resume Page</a></li>
                                <li><a href="#" class="pb-1 d-block">Dashboard</a></li>
                                <li><a href="#" class="pb-1 d-block">Job Packages</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="ftco-footer-widget mb-4 ml-md-4">
                            <h2 class="ftco-heading-2">Candidate</h2>
                            <ul class="list-unstyled">
                                <li><a href="#" class="pb-1 d-block">Browse Jobs</a></li>
                                <li><a href="#" class="pb-1 d-block">Submit Resume</a></li>
                                <li><a href="#" class="pb-1 d-block">Dashboard</a></li>
                                <li><a href="#" class="pb-1 d-block">Browse Categories</a></li>
                                <li><a href="#" class="pb-1 d-block">My Bookmarks</a></li>
                                <li><a href="#" class="pb-1 d-block">Candidate Listing</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="ftco-footer-widget mb-4 ml-md-4">
                            <h2 class="ftco-heading-2">Account</h2>
                            <ul class="list-unstyled">
                                <li><a href="#" class="pb-1 d-block">My Account</a></li>
                                <li><a href="#" class="pb-1 d-block">Sign In</a></li>
                                <li><a href="#" class="pb-1 d-block">Create Account</a></li>
                                <li><a href="#" class="pb-1 d-block">Checkout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="ftco-footer-widget mb-4">
                            <h2 class="ftco-heading-2">Have a Questions?</h2>
                            <div class="block-23 mb-3">
                                <ul>
                                    <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St.
                                            Mountain View, San Francisco, California, USA</span></li>
                                    <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392
                                                3929 210</span></a></li>
                                    <li><a href="#"><span class="icon icon-envelope"></span><span
                                                class="text">info@yourdomain.com</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">

                        <p>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i
                                class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </body>


    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00" />
        </svg></div>


    <script src="{{ url('assets') }}/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="{{ url('assets') }}/js/popper.min.js"></script>
    <script src="{{ url('assets') }}/js/bootstrap.min.js"></script>
    <script src="{{ url('assets') }}/js/jquery.easing.1.3.js"></script>
    <script src="{{ url('assets') }}/js/jquery.waypoints.min.js"></script>
    <script src="{{ url('assets') }}/js/jquery.stellar.min.js"></script>
    <script src="{{ url('assets') }}/js/owl.carousel.min.js"></script>
    <script src="{{ url('assets') }}/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ url('assets') }}/js/aos.js"></script>
    <script src="{{ url('assets') }}/js/jquery.animateNumber.min.js"></script>
    <script src="{{ url('assets') }}/js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="{{ url('assets') }}/js/google-map.js"></script>
    <script src="{{ url('assets') }}/js/main.js"></script>


    @auth
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        @if (Auth::user()->role == 'admin')
            <script>
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('83bf01955ed9cacf4a2a', {
                    cluster: 'ap2'
                });

                var channel = pusher.subscribe('notification-channel');
                channel.bind('notification-event', function(data) {
                   var c =  confirm("You have a request to discuss budget, click ok to go to discussion screen.");
                   if(c){
                       window.location.href = data['url'];
                   }
                });
            </script>
        @endif
    @endauth
    @yield('js')
