<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo pendarasa.jpg') }}">
    <title>Reset Password - Pendarasa</title>
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
</head>

<body>
    <div class="row justify-content-center" style="margin-top: 85px;">
        <div class="col col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('img/logo pendarasa.jpg') }}" alt="logo"
                            style="max-width: 150px; min-width: 150px;">
                    </div>
                    <form action="{{ route('resetAkun.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="Nik" class="form-label">NIK</label>
                            <input type="text" name="nik" id="Nik" class="form-control" placeholder="NIK"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="Password" class="form-label">NO HP</label>
                            <input type="password" name="no_hp" id="Password" class="form-control mb-1"
                                placeholder="08662123123" required>
                        </div>
                        <button type="submit" class="btn btn-primary me-1">Reset</button>
                        <a href="{{ route('login') }}" class="btn btn-warning">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('vendors/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vendors/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendors/js/menu.js') }}"></script>
    <script src="{{ asset('vendors/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/dashboards-analytics.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    {{-- <script>
        window.onload = function() {
            const loadingScreen = document.getElementById('loadingScreen');
            setTimeout(function() {
                loadingScreen.classList.add('loaded');
            }, 2000);
        };
    </script> --}}
    @include('sweetalert::alert')
</body>

</html>
