<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>انتِ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('front_style/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('front_style/assets/vendor/bootstrap/css/bootstrap.rtl.min.css')}}" rel="stylesheet">
    <link href="{{asset('front_style/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('front_style/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('front_style/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('front_style/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('front_style/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset('front_style/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('front_style/assets/css/custom.css')}}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Arsha - v4.7.1
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="{{route('home')}}"><img src="{{asset('front_style/image/logo.png')}}"></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul class="m-auto" style="
        margin-left: 400px !important;">
                    <li><a class="nav-link scrollto active" href="{{route('home')}}">الرئيسية</a></li>
                    <li><a class="nav-link scrollto" href="{{route('user.wasfas.index')}}">وصفاتنا</a></li>
                    <li><a class="nav-link scrollto" href="{{route('chif.index')}}">الشيفات</a></li>
                    @if(!Auth::check()==1)
                    <li><a class="nav-link   scrollto" href="{{route('register')}}">انضم الينا</a></li>
                    @else
                    <li><a class="nav-link   scrollto" href="{{route('user.reservation.index')}}"> حجوزات</a></li>
                    <li><a class="nav-link   scrollto" href="{{route('user.wasfas.user')}}"> وصفاتي</a></li>

                    @endif
                </ul>
                </li>
                </ul>
                <ul>
                    @if(\Auth::check())
                    <li class="dropdown"><a href="#"><span><i class="fas fas-bell"></i><span>{{auth()->user()->name}}</span></span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            @if(auth()->user()->role!='user')
                            <li><a href="{{route('admin')}}" class="dropdown-item">dashborad</a></li>
                            @endif
                            <li>

                                <form method="POST" action="{{route('logout')}}">
                                    @csrf
                                    <button class="dropdown-item" href="{{ route('logout') }}"><i class="bx bx-log-out"></i>
                                        <i class="fa fa-sign-out fa-lg"></i> تسجيل الخروج</button>

                                </form>

                            </li>
                        </ul>
                    </li>

                    @else
                    <li><button class="btn-started register-btn" data-toggle="modal" data-target="#orangeModalSubscription">تسجيل الدخول</button></li>

                    @endauth
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
    <!-- end page-ban-list -->
    @yield('content')

    @include('sweetalert::alert')
    @include('layouts.footer') @stack('scripts')