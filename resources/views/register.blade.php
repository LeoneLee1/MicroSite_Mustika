<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo oval mustika.png') }}">
    <title>Login - PT Mustika Jaya Lestari</title>
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
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 85px;">
            <div class="col col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Daftar Akun</h3>
                        <form action="{{ route('register.insert') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="Nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="Nama" class="form-control"
                                    placeholder="Nama Lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="Nik" class="form-label">NIK</label>
                                <input type="text" name="nik" id="Nik" class="form-control"
                                    placeholder="NIK" required>
                            </div>
                            <div class="mb-3">
                                <label for="Unit" class="form-label">Unit</label>
                                <select name="unit" class="form-control" id="Unit">
                                    <option value="" selected disabled>Pilih Unit</option>
                                    @foreach ($unit as $item)
                                        <option value="{{ $item->kodeunit }}">{{ $item->kodeunit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" name="password" id="Password" class="form-control"
                                    placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Daftar</button>
                            <a href="{{ route('login') }}" class="btn btn-warning">Batal</a>
                        </form>
                    </div>
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
</body>

</html>
