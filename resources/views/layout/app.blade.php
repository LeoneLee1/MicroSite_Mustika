<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo oval mustika.png') }}">
    <title>@yield('title')</title>
    @stack('before-style')
    @include('includes.main.style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
    <style>
        .swal2-container {
            z-index: 9999 !important;
        }


        /* .preload {
            position: fixed;
            width: 100vw;
            height: 100vh;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #0d3d6e;
            z-index: 10000;
        }

        .preload.loaded {
            display: none;
        }

        .preload video {
            max-width: 130%;
            max-height: 130%;
        } */
    </style>
    @stack('after-style')
</head>

<body>
    {{-- <div class="preload" id="loadingScreen">
        <video autoplay muted loop src="{{ asset('video/loading.mp4') }}"></video>
    </div> --}}
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('includes.main.sidebar')
            <div class="layout-page">
                {{-- @include('includes.main.navbar') --}}
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="fa fa-list"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        @yield('navbar-item')
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item lh-1 me-3">
                                <p class="mt-3">Hi, {{ Auth::user()->nama }}</p>
                            </li>
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        @if (Auth::user()->foto == '' || null)
                                            <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                                alt="avatar profile" class="w-px-40 h-auto rounded-circle lazyload" />
                                        @else
                                            <img src="{{ asset('img/foto/' . Auth::user()->foto) }}"
                                                alt="avatar profile" class="w-px-40 h-auto rounded-circle lazyload" />
                                        @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item {{ request()->is('profile*') ? 'active' : '' }}"
                                            href="{{ route('profile') }}">
                                            <i class="fa fa-id-card"></i>
                                            <span class="align-middle">&nbsp;Edit Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}">
                                            <i class="fa fa-power-off"></i>
                                            <span class="align-middle">&nbsp;Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        @yield('backButtonDown')
    </div>
    @include('sweetalert::alert')
    @stack('before-script')
    @include('includes.main.script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    @stack('after-script')
    {{-- <script>
        window.onload = function() {
            const loadingScreen = document.getElementById('loadingScreen');
            setTimeout(function() {
                loadingScreen.classList.add('loaded');
            }, 2000);
        };
    </script> --}}
</body>

</html>
