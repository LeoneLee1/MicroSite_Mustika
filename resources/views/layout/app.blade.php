<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo pendarasa.jpg') }}">
    <title>@yield('title')</title>
    @stack('before-style')
    @include('includes.main.style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <style>
        .swal2-container {
            z-index: 9999 !important;
        }

        .nav-item .badge {
            position: absolute;
            top: 0;
            /* Sesuaikan posisi */
            right: 0;
            /* Sesuaikan posisi */
            background-color: red;
            color: white;
            border-radius: 50%;
            font-size: 10px;
            padding: 4px 6px;
            line-height: 1;
            transform: translate(50%, -50%);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px;
            font-size: 5px;
            line-height: 1;
        }

        .navbar-custom {
            background-color: #696cff !important;
        }

        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .mobile-bottom-nav-container {
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
        }

        .mobile-bottom-nav .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #697a8d;
            font-size: 12px;
        }

        .mobile-bottom-nav .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .mobile-bottom-nav .nav-item.active {
            color: #696cff;
        }

        .mobile-bottom-nav .logo-item {
            position: absolute;
            bottom: 70%;
            left: 50%;
            transform: translate(-50%, 50%);
        }

        /* Add padding to main content to prevent overlap with bottom nav */
        @media (max-width: 575.98px) {
            .layout-page {
                padding-bottom: 70px !important;
            }
        }

        #loader {
            border: 12px solid #070440;
            border-radius: 50%;
            border-top: 12px solid #ffffff;
            width: 70px;
            height: 70px;
            animation: spin 1s linear infinite;
        }

        .center {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    @stack('after-style')
</head>

<body>
    <div id="loader" class="center"></div>
    <div class="layout-wrapper layout-content-navbar page">
        <div class="layout-container">
            @include('includes.main.sidebar')
            <div class="mobile-bottom-nav d-block d-sm-none">
                <div class="mobile-bottom-nav-container">
                    @if (Auth::user()->role === 'Admin')
                        <a href="{{ route('beranda') }}"
                            class="nav-item {{ request()->is('beranda') ? 'active' : '' }}">
                            <i class="fa fa-home"></i>
                            <span>Beranda</span>
                        </a>
                        <a href="{{ route('post') }}" class="nav-item {{ request()->is('post') ? 'active' : '' }}">
                            <i class="fa fa-square-plus"></i>
                            <span>Buat</span>
                        </a>
                        <a href="#"
                            class="nav-item 
                            {{ request()->is('analysis') ? 'active' : '' }} 
                            {{ request()->is('user') ? 'active' : '' }} 
                            {{ request()->is('register/data') ? 'active' : '' }} 
                            {{ request()->is('admin/postingan') ? 'active' : '' }}
                            {{ request()->is('log') ? 'active' : '' }}"
                            data-bs-toggle="modal" data-bs-target="#menu">
                            <i class="fa fa-bars"></i>
                            <span>Main Menu</span>
                        </a>
                        <a href="{{ route('profile') }}"
                            class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
                            <i class="fa fa-user-pen"></i>
                            <span>Profile</span>
                        </a>
                    @endif
                    @if (Auth::user()->role === 'User' || Auth::user()->role === 'Pengamat')
                        <a href="{{ route('beranda') }}"
                            class="nav-item {{ request()->is('beranda') ? 'active' : '' }}">
                            <i class="fa fa-home"></i>
                            <span>Beranda</span>
                        </a>
                        <a href="{{ route('analysis') }}"
                            class="nav-item {{ request()->is('analysis') ? 'active' : '' }}">
                            <i class="fa fa-chart-simple"></i>
                            <span>Analysis</span>
                        </a>
                        <a href="{{ route('profile') }}"
                            class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
                            <i class="fa fa-user-pen"></i>
                            <span>Profile</span>
                        </a>
                    @endif
                    <a href="{{ route('logout') }}" class="nav-item" onclick="return confirmLogout()">
                        <i class="fa fa-power-off"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div
                        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none d-none d-sm-block">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="fa fa-list"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        @yield('navbar-item')
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            @include('layout.notif')
                            <li class="nav-item lh-1 me-3">
                                <p class="mt-3" style="font-size: 13px;" class="d-block">{{ Auth::user()->nama }}
                                </p>
                            </li>
                            <li class="nav-item">
                                <div class="nav-link">
                                    <div class="avatar avatar-online">
                                        @if (Auth::user()->foto == '' || null)
                                            <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                                alt="avatar profile" class="w-px-40 h-auto rounded-circle lazyload" />
                                        @else
                                            <img src="{{ asset('img/foto/' . Auth::user()->foto) }}"
                                                alt="avatar profile" class="w-px-40 h-20 rounded-circle lazyload" />
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                        @include('modal.menu')
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
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    @stack('after-script')
    <script>
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector("body").style.visibility = "hidden";
                document.querySelector("#loader").style.visibility = "visible";
            }
        };

        window.onload = function() {
            // Menunggu 500ms tambahan untuk memastikan semua sudah siap
            setTimeout(function() {
                document.querySelector("#loader").style.display = "none";
                document.querySelector("body").style.visibility = "visible";
            }, 500);
        };
    </script>
    <script>
        function confirmLogout() {
            if (confirm('Logout?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#notification-dropdown').on('click', function(e) {
                e.preventDefault();
                $('.notification-badge').remove();
                $.ajax({
                    url: "{{ route('delete.badge') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Gagal menghapus badge:', xhr.responseText || error);
                    }
                });
            });
        });
    </script>
</body>

</html>
