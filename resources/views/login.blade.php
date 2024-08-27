<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo oval mustika.png') }}">
    <title>Login - PT Mustika Jaya Lestari</title>
    @include('includes.style')
</head>

<body>

    <div class="container">
        <div class="row justify-content-center" style="margin-top: 85px;">
            <div class="col col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('img/logo oval mustika.png') }}" alt="logo"
                                style="max-width: 150px; min-width: 150px;">
                        </div>
                        <form action="{{ route('login.proses') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="Nik" class="form-label">NIK</label>
                                <input type="text" name="nik" id="Nik" class="form-control"
                                    placeholder="NIK" required>
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" name="password" id="Password" class="form-control"
                                    placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        <p class="mt-4 text-center">
                            <span>Belum Punya Akun?</span>
                            <a href="{{ route('register') }}">Buat Akun!</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.script')
    @include('sweetalert::alert')
</body>

</html>
