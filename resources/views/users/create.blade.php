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
                            <label for="Nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="Nama" class="form-control" required
                                placeholder="Nama Lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="Nik" class="form-label">Username / Nik</label>
                            <input type="text" name="nik" id="Nik" class="form-control"
                                placeholder="Username / NIK" required>
                        </div>
                        <div class="mb-3">
                            <label for="Unit" class="form-label">Unit</label>
                            <select name="unit" class="form-control" required>
                                <option value="" selected disabled>Pilih Unit</option>
                                @foreach ($data as $row)
                                    <option value="{{ $row->kodeunit }}">{{ $row->kodeunit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Gender" class="form-label">Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="" disabled selected>Pilih Gender</option>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Role" class="form-label">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                                <option value="Pengamat">Pengamat</option>
                                <option value="Anonymous">Anonymous</option>
                            </select>
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
