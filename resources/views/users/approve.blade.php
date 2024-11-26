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
                                <label style="color: black;">NAMA</label>
                                <input type="text" name="nama" class="form-control" value="{{ $data->nama }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label style="color: black;">NIK</label>
                                <input type="text" name="nik" class="form-control" value="{{ $data->nik }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label style="color: black;">UNIT</label>
                                <input type="text" name="unit" class="form-control" value="{{ $data->unit }}"
                                    required>
                            </div>
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
                            <div class="form-group">
                                <label style="color: black;">PASSWORD</label>
                                <input type="text" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary" onclick="return Approve()">APPROVE</button>
                        <a href="javascript:void(0)" onclick="window.history.go(-1); return false;"
                            class="btn btn-warning btn-sm">BATAL</a>
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
