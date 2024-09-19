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
                @include('includes.main.navbar')
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
