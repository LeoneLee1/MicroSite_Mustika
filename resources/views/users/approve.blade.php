@extends('layout.app')

@section('title', 'Approve - Pendarasa')

@section('navbar-item')
    <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-info"><i
            class="fa fa-arrow-left"></i>&nbsp;Back</a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.approve', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="no_hp" value="{{ $data->no_hp }}">
                        <div class="mb-3">
                            <div class="form-group">
                                <label style="color: black;">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $data->nama }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label style="color: black;">Nik</label>
                                <input type="text" name="nik" class="form-control" value="{{ $data->nik }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label style="color: black;">Unit</label>
                                <input type="text" name="unit" class="form-control" value="{{ $data->unit }}"
                                    required>
                            </div>
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
                            <div class="form-group">
                                <label style="color: black;">Password</label>
                                <input type="text" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary" onclick="return Approve()">Approve</button>
                        <a href="javascript:void(0)" onclick="window.history.go(-1); return false;"
                            class="btn btn-warning btn-sm">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        function Approve() {
            if (confirm("Aprrove?")) {
                console.log("terkirim");
                return true;
            } else {
                console.log("Batal");
                return false;
            }
        }
    </script>
@endpush
