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
    @include('includes.script')
</body>

</html>
