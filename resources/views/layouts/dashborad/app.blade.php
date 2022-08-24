<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Plate diet ">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>{{config('app.name')}} -Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <!-- Font-icon css-->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/brands.min.css" integrity="sha512-rQgMaFKZKIoTKfYInSVMH1dSM68mmPYshaohG8pK17b+guRbSiMl9dDbd3Sd96voXZeGerRIFFr2ewIiusEUgg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{asset('dashbord_style/css/main.css')}}">
    @stack('css')
</head>

<body class="app sidebar-mini">>
    <header class="app-header"><a class="app-header__logo" href="{{route('home')}}"> أنتِ</a>
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

        <ul class="app-nav">

            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="{{route('admin.profile')}}"><i class="fa fa-user fa-lg"></i> تعديل بيانات الشخصية</a></li>
                    <li>

                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <button class="dropdown-item" href="{{ route('logout') }}"><i class="bx bx-log-out"></i>
                                <i class="fa fa-sign-out fa-lg"></i> تسجيل الخروج</button>

                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{asset('assets/users/'.auth()->user()->image)}}" alt="User Image" width="100px" height="100px" style="
    margin: auto;">
            <div>
                <p class="app-sidebar__user-name"></p>
                <p class="app-sidebar__user-designation"></p>
            </div>
        </div>
        <ul class="app-menu">
            <li><a class="app-menu__item active" href="{{route('admin')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">لوحة التحكم</span></a></li>
            @can('wasfas-index')
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">مقالات</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    @can('category-index')
                    <li><a class="treeview-item" href="{{route('admin.wasfas.index')}}" rel="noopener"><i class="icon fa fa-circle-o"></i> وصفات</a></li>
                    @endcan
                    @can('wasfas-index')
                    <li><a class="treeview-item" href="{{route('admin.categories.index')}}"><i class="icon fa fa-circle-o"></i> اقسام</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('ratingreservation-index')
            <li><a class="app-menu__item" href="{{route('admin.ratingreservation.index')}}"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">حجوزات</span></a></li>
            @endcan
            @can('users-index')
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">المستخدمين</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    @can('role-index')
                    <li><a class="treeview-item" href="{{route('admin.roles.index')}}"><i class="icon fa fa-circle-o"></i> الصلاحيات</a></li>
                    @endcan
                    @can('supervisors-index')
                    <li><a class="treeview-item" href="{{route('admin.supervisors.index')}}"><i class="icon fa fa-circle-o"></i> المشرفين</a></li>
                    @endcan
                    @can('chef-index')
                    <li><a class="treeview-item" href="{{route('admin.chefs.index')}}"><i class="icon fa fa-circle-o"></i> طباخين </a></li>
                    @endcan
                    @can('users-index')
                    <li><a class="treeview-item" href="{{route('admin.users.index')}}"><i class="icon fa fa-circle-o"></i>المستخدمين</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">عمليات المستخدمين</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">

                    @can('wasfas-users')
                    <li><a class="treeview-item" href="{{route('admin.wasfas.users')}}"><i class="icon fa fa-circle-o"></i> طلب الوصفات</a></li>
                    @endcan

                    @can('reservation-index')
                    <li><a class="treeview-item" href="{{route('admin.reservation.index')}}"><i class="icon fa fa-circle-o"></i>حجوزات المستخدمين</a></li>
                    @endcan
                    @can('services-subscribeChif')
                    <li><a class="treeview-item" href="{{route('admin.services.subscribechif')}}"><i class="icon fa fa-circle-o"></i>اشتراك المستخدمين</a></li>
                    @endcan
                    @can('rating-index')
                    <li><a class="treeview-item" href="{{route('user.rating.index')}}"><i class="icon fa fa-circle-o"></i>تقييم الوصفات</a></li>
                    @endcan

                </ul>
            </li>
            @can('services-index')
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">ادارة</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    @can('services-index')
                    <li><a class="treeview-item" href="{{route('admin.services.index')}}"><i class="icon fa fa-circle-o"></i> خدمات الموقع </a></li>
                    @endcan
                    @can('contactus-index')
                    <li><a class="treeview-item" href="{{route('admin.contactus.index')}}"><i class="icon fa fa-circle-o"></i> تعليقات المستخدمين </a></li>
                    @endcan
                    @can('settings-index')
                    <li><a class="treeview-item" href="{{route('admin.settings.index')}}"><i class="icon fa fa-circle-o"></i> اعدادات الموقع </a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            <li><a class="app-menu__item" href="{{route('home')}}" target="_blank"><i class="app-menu__icon fa fa-file-code-o"></i><span class="app-menu__label">صفحة الموقع</span></a></li>
        </ul>
    </aside>
    <main class="app-content"> @yield('content')
    </main>


    @include('sweetalert::alert')
    @include('layouts.dashborad.footer') @stack('scripts')