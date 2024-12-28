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
    </style>
    @stack('after-style')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar page">
        <div class="layout-container">
            @include('includes.main.sidebar')
            <div class="layout-page">
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
                            @include('layout.notif')
                            <li class="nav-item lh-1 me-3">
                                <p class="mt-3" style="font-size: 13px;" class="d-block">{{ Auth::user()->nama }}
                                </p>
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
                                                alt="avatar profile" class="w-px-40 h-20 rounded-circle lazyload" />
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
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    @stack('after-script')
    <script>
        function Logout() {
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
                // $.ajax({
                //     url: "{{ route('delete.NotifBadge') }}",
                //     type: "GET",
                //     success: function(response) {
                //         console.log(response.message);
                //         $('.notification-badge').remove();
                //     },
                //     error: function(xhr) {
                //         console.error(xhr.responseText);
                //     }
                // });
            });
        });
    </script>
</body>

</html>
