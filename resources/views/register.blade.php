<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo pendarasa.jpg') }}">
    <title>Register - Pendarasa</title>
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
    {{-- <div class="preload" id="loadingScreen">
        <video autoplay muted loop src="{{ asset('video/loading.mp4') }}"></video>
    </div> --}}
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
                                    oninput="this.value = this.value.toUpperCase()" placeholder="Nama Lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" id="autoInput" class="form-control"
                                    oninput="this.value = this.value.toUpperCase()" placeholder="NIK" required>
                            </div>
                            <div class="mb-3">
                                <label for="Unit" class="form-label">Unit</label>
                                <select name="unit" class="form-control" id="Unit" required>
                                    <option value="" selected disabled>Pilih Unit</option>
                                    @foreach ($unit as $item)
                                        <option value="{{ $item->kodeunit }}">{{ $item->kodeunit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Gender" class="form-label">Jenis Kelamin</label>
                                <select name="gender" class="form-control" required>
                                    <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="No_Hp" class="form-label">Nomor HP</label>
                                <input type="text" name="no_hp" id="No_Hp" maxlength="15" class="form-control"
                                    placeholder="Nomor WhatsApp 085312341234" required oninput="validatePhoneNumber()">
                                <small id="charCount" class="form-text text-muted">0/15</small> <br>
                                <small>Nomor Whatsapp atau Nomor Handphone yang bisa dihubungi sebagai konfirmasi
                                    nantinya!</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Daftar</button>
                            <a href="{{ route('login') }}" class="btn btn-warning">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('vendors/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vendors/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendors/js/menu.js') }}"></script>
    <script src="{{ asset('vendors/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/dashboards-analytics.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        function validatePhoneNumber() {
            const inputField = document.getElementById('No_Hp');
            const charCount = document.getElementById('charCount');

            // Hanya mengizinkan angka
            inputField.value = inputField.value.replace(/\D/g, '');

            // Menampilkan jumlah karakter
            charCount.textContent = `${inputField.value.length}/15`;
        }
    </script>
    <script>
        document.getElementById("autoInput").addEventListener("keydown", function(e) {
            const txt = this.value;
            // prevent more than 12 characters, ignore the spacebar, allow the backspace
            if ((txt.length == 20 || e.which == 40) & e.which !== 8) e.preventDefault();
            // add spaces after 3 & 7 characters, allow the backspace
            if ((txt.length == 4 || txt.length == 8) && e.which !== 8)
                this.value = this.value + ".";
        });
    </script>
</body>

</html>
