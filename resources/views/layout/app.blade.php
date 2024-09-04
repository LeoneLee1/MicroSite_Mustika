<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo oval mustika.png') }}">
    <title>@yield('title')</title>
    @stack('before-style')
    @include('includes.main.style')
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
    @include('includes.main.script')
    @stack('after-script')
</body>

</html>
