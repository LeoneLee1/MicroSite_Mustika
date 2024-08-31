<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo oval mustika.png') }}">
    <title>@yield('title')</title>
    @stack('before-style')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('vendors/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/libs/apex-charts/apex-charts.css') }}">
    <script src="{{ asset('vendors/js/helpers.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>
    <style>
        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
    @stack('after-style')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('includes.main.sidebar')
            <div class="layout-page">
                @include('includes.main.navbar')
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
    @stack('before-script')
    <script src="{{ asset('vendors/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vendors/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vendors/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendors/js/menu.js') }}"></script>
    <script src="{{ asset('vendors/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/dashboards-analytics.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @stack('after-script')
</body>

</html>
