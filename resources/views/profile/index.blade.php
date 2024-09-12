@extends('layout.app')

@section('title', 'User Profile - PT Mustika Jaya Lestari')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- desktop --}}
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
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-4">Edit Profile</a>
                        </div>
                    </div>
                    <div class="profile-info">
                        <div class="tab-content">
                            <div id="personal-info" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="profile_column">
                                            <span class="profile_title">Nama Lengkap</span>
                                            <span class="profile_content">{{ $item->nama }}</span>
                                        </div>
                                        <div class="profile_column">
                                            <span class="profile_title">Username / NIK</span>
                                            <span class="profile_content">{{ $item->nik }}</span>
                                        </div>
                                        <div class="profile_column">
                                            <span class="profile_title">Unit</span>
                                            <span class="profile_content">{{ $item->unit }}</span>
                                        </div>
                                        <div class="profile_column">
                                            <span class="profile_title">Gender</span>
                                            @if ($item->gender == null || '')
                                                <span class="profile_content">-</span>
                                            @else
                                                <span class="profile_content">{{ $item->gender }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
