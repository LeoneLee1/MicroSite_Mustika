@extends('layout.app')

@section('title', 'User Create - PT Mustika Jaya Lestari')

@section('content')

@section('content')
    <div class="row justify-content-center">
        <div class="col col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="Nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="Nama" class="form-control" required
                                placeholder="Nama Lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="Nik" class="form-label">Nik</label>
                            <input type="text" name="nik" id="Nik" class="form-control" placeholder="NIK"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="Unit" class="form-label">Unit</label>
                            <input type="text" name="unit" id="Unit" class="form-control" required
                                placeholder="Kode Unit">
                        </div>
                        <div class="mb-3">
                            <label for="Password" class="form-label">Password</label>
                            <input type="text" name="password" id="Password" class="form-control" required
                                placeholder="Password Anda">
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                        <a href="{{ route('user') }}" class="btn btn-sm btn-warning">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
