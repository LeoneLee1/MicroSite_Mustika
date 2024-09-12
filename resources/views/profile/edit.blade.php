@extends('layout.app')

@section('title', 'User Profile Edit - PT Mustika Jaya Lestari')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/profileEdit.css') }}">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="page__center container" style="width: 100%;">
                @foreach ($data as $item)
                    <div class="profile_header">
                        <div class="pic_wrapper">
                            @if ($item->foto == null || '')
                                <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                    alt="Avatar">
                            @else
                                <img src="{{ $item->foto }}" alt="Avatar">
                            @endif
                        </div>
                        <div class="name_wrapper">
                            <h2 style="color: #003366; font-weight: bold;">{{ $item->nama }}</h2>
                            <h5 style="color: black;">{{ $item->nik }}</h5>
                        </div>
                        <div class="pull_right">
                            <a href="{{ route('profile') }}" class="btn btn-primary mt-4">Back</a>
                        </div>
                    </div>
                    <div class="profile-info edit_profile">
                        <div class="tab-content">
                            <div class="personal-info" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="{{ route('profile.insert') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" class="form-control"
                                                value="{{ Auth::user()->id }}">
                                            <div class="form-group" style="color: black; font-weight:bold;">
                                                <label>Nama Lengkap</label>
                                                <input type="text" class="form-control" value="{{ $item->nama }}"
                                                    name="nama">
                                            </div>
                                            <div class="form-group" style="color: black; font-weight:bold;">
                                                <label>Username / NIK</label>
                                                <input type="text" class="form-control" value="{{ $item->nik }}"
                                                    name="nik">
                                            </div>
                                            <div class="form-group" style="color: black; font-weight:bold;">
                                                <label>Gender</label>
                                                <select class="form-control" name="gender">
                                                    <option value="{{ $item->gender }}" selected disabled>
                                                        {{ $item->gender }}
                                                    </option>
                                                    <option value="Pria">Pria</option>
                                                    <option value="Wanita">Wanita</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" style="color: black; font-weight:bold;">
                                            <label>Unit</label>
                                            <select class="form-control" name="unit">
                                                <option value="{{ $item->unit }}" selected disabled>
                                                    {{ $item->unit }}
                                                </option>
                                                @foreach ($unit as $u)
                                                    <option value="{{ $u->kodeunit }}">{{ $u->kodeunit }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <h6 class="mt-5" style="color: black; font-weight: bold;">Foto Profil</h6>
                                        <span class="span-helper" style="color: black;">Upload Foto Baru</span>
                                        <div class="form-group mt-3">
                                            <input type="text" name="foto" class="form-control"
                                                value="{{ $item->foto }}" placeholder="Link Url Foto">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
