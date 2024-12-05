@extends('layout.app')

@section('title', 'User Create - Pendarasa')

@section('content')

@section('content')
    <div class="row justify-content-center">
        <div class="col col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="Nama" class="form-label">NAMA</label>
                            <input type="text" name="nama" id="Nama" class="form-control" required
                                placeholder="Nama Lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="Nik" class="form-label">NIK</label>
                            <input type="text" name="nik" id="Nik" class="form-control"
                                placeholder="Username / NIK" required>
                        </div>
                        <div class="mb-3">
                            <label for="Nik" class="form-label">NOMOR HP</label>
                            <input type="number" name="no_hp" id="Nik" class="form-control"
                                placeholder="08523423423" required>
                        </div>
                        <div class="mb-3">
                            <label for="Unit" class="form-label">UNIT</label>
                            <select name="unit" class="form-control" required>
                                <option value="" selected disabled>PILIH UNIT</option>
                                @foreach ($data as $row)
                                    <option value="{{ $row->kodeunit }}">{{ $row->kodeunit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Gender" class="form-label">GENDER</label>
                            <select name="gender" class="form-control" required>
                                <option value="" disabled selected>PILIH GENDER</option>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Role" class="form-label">ROLE</label>
                            <select name="role" class="form-control" required>
                                <option value="" disabled selected>PILIH ROLE</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                                <option value="Pengamat">Pengamat</option>
                                <option value="Anonymous">Anonymous</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Password" class="form-label">PASSWORD</label>
                            <input type="text" name="password" id="Password" class="form-control" required
                                placeholder="Password Anda">
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">SIMPAN</button>
                        <a href="{{ route('user') }}" class="btn btn-sm btn-warning">BATAL</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
