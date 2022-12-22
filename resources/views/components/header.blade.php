<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Chameleon Admin is a modern Bootstrap 4 webapp &amp; admin dashboard html template with a large number of components, elegant design, clean and organized code.">
    <meta name="keywords" content="admin template, Chameleon admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>Student Pass - Admin Dashboard</title>
    <link rel="apple-touch-icon" href="/storage/theme-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/storage//storage/theme-assets/images/ico/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/font-awesome-line-awesome/css/all.min.css" integrity="sha512-dC0G5HMA6hLr/E1TM623RN6qK+sL8sz5vB+Uc68J7cBon68bMfKcvbkg6OqlfGHo1nMmcCxO5AinnRTDhWbWsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="/storage/theme-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="/storage/theme-assets/vendors/css/charts/chartist.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN CHAMELEON  CSS-->
    <link rel="stylesheet" type="text/css" href="/storage/theme-assets/css/app-lite.css">
    <!-- END CHAMELEON  CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="/storage/theme-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="/storage/theme-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="/storage/theme-assets/css/pages/dashboard-ecommerce.css">
    <style>
        .close-modal{
            top: 2.5px!important;
            right: 1.5px!important;
        }
        .modal{
            font-size: 18px;
            font-weight: bold;
        }
    </style>
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="collapse navbar-collapse show" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                        <ul class="dropdown-menu">
                            <li class="arrow_box">
                                <form>
                                    <div class="input-group search-box">
                                        <div class="position-relative has-icon-right full-width">
                                            <input class="form-control" id="search" type="text" placeholder="Search here...">
                                            <div class="form-control-position navbar-search-close"><i class="ft-x">   </i></div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">             <span class="avatar avatar-online"><img src="@if(isset($userLogged["image"]->path))/{{$userLogged["image"]->path}}"@else/storage/theme-assets/images/portrait/small/avatar-s-19.png" @endif alt="avatar"><i></i></span></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="arrow_box_right"><a class="dropdown-item" href="#"><span class="avatar avatar-online"><img src="@if(isset($userLogged["image"]->path))/{{$userLogged["image"]->path}}"@else/storage/theme-assets/images/portrait/small/avatar-s-19.png" @endif alt="avatar"><span class="user-name text-bold-700 ml-1">{{$userLogged["user"]->fname}} {{$userLogged["user"]->lname}}</span></span></a>
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"><i class="ft-power"></i> Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->


<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="/storage/theme-assets/images/backgrounds/02.jpg">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="index.html">
                    <h3 class="brand-text">Student Pass Admin</h3></a></li>
            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" @if($currPage == "0") active @endif "><a href="/admin"><i class="ft-home"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
            </li>
            <li class=" nav-item  @if($currPage == "1") active @endif"><a href="/users"><i class="ft-users"></i><span class="menu-title" data-i18n="">Korisnici</span></a>
            </li>
            <li class=" nav-item  @if($currPage == "2") active @endif"><a href="/posts"><i class="ft-arrow-up"></i><span class="menu-title" data-i18n="">Postovi</span></a>
            </li>
            <li class=" nav-item  @if($currPage == "3") active @endif"><a href="/categories"><i class="ft-layers"></i><span class="menu-title" data-i18n="">Kategorije</span></a>
            </li>
            <li class=" nav-item  @if($currPage == "4") active @endif"><a href="/reviews"><i class="ft-align-center"></i><span class="menu-title" data-i18n="">Recenzije</span></a>
            </li>
            <li class=" nav-item  @if($currPage == "5") active @endif"><a href="/colleges"><i class="ft-book"></i><span class="menu-title" data-i18n="">Fakulteti</span></a>
            </li>
            <li class=" nav-item  @if($currPage == "6") active @endif"><a href="/images"><i class="ft-image"></i><span class="menu-title" data-i18n="">Slike</span></a>
            </li>
            <li class=" nav-item  @if($currPage == "7") active @endif"><a href="/companies"><i class="ft-compass"></i><span class="menu-title" data-i18n="">Firme</span></a>
            </li>
            <li class=" nav-item  @if($currPage == "8") active @endif"><a href="/analytics"><i class="ft-pie-chart"></i><span class="menu-title" data-i18n="">Analitika</span></a>
            </li>
            <li class=" nav-item  @if($currPage == "9") active @endif"><a href="/student_card"><i class="ft-credit-card"></i><span class="menu-title" data-i18n="">Studentske kartice</span></a>
            </li>
        </ul>
    </div>
    <div class="navigation-background"></div>
    <!-- Login modal embedded in page -->
    <div id="validation-modal" class="modal">
        ...
    </div>
</div>
