@extends('layout.app')

@section('title', 'User Profile - Pendarasa')

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
                            @if ($item->foto == '' || null)
                                <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                    alt="Avatar">
                            @else
                                <img src="{{ asset('img/foto/' . $item->foto) }}" alt="Avatar">
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
    <div class="card mt-2">
        <div class="card-body">
            <div class="container">
                <header class="d-flex justify-content-center">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="#"
                                class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">Postingan</a></li>
                        <li class="nav-item"><a href="{{ route('profile.tersimpan') }}" class="nav-link">Tersimpan</a></li>
                    </ul>
                </header>
            </div>
            <div class="card-body">
                @if ($post === null || collect($post)->isEmpty())
                    <div class="text-center mb-4">
                        <span>You haven't posted anything yet</span>
                    </div>
                @else
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">No</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Media</th>
                                        <th scope="col">Like</th>
                                        <th scope="col">Comment</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($post as $p)
                                        <tr class="text-center" style="color: black;">
                                            <th scope="col">{{ $loop->index + 1 }}</th>
                                            <td title="{{ $p->judul }}">{!! Str::limit($p->judul, 15, '....') !!}</td>
                                            <td>
                                                @if (strpos($p->media, '.mp4') !== false || strpos($p->media, '.webm') !== false || strpos($p->media, '.ogg') !== false)
                                                    <video controls class="img-fluid">
                                                        <source src="{{ $p->media }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @elseif (strpos($p->media, 'youtube.com') !== false || strpos($p->media, 'youtu.be') !== false)
                                                    @php
                                                        preg_match(
                                                            '/(youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/',
                                                            $p->media,
                                                            $matches,
                                                        );
                                                        $youtubeId = $matches[2];
                                                    @endphp
                                                    <div class="d-none d-sm-block">
                                                        <iframe style="max-width: 300px; min-width: 300px; height: auto;"
                                                            src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen class="img-fluid lazyload"></iframe>
                                                    </div>
                                                    <div class="d-block d-sm-none">
                                                        <iframe style="max-width: 300px; min-width: 300px; height: auto;"
                                                            src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen class="img-fluid lazyload"></iframe>
                                                    </div>
                                                @elseif (strpos($p->media, '.jpg') !== false ||
                                                        strpos($p->media, '.jpeg') !== false ||
                                                        strpos($p->media, '.png') !== false ||
                                                        strpos($p->media, 'data:image') !== false ||
                                                        strpos($p->media, '.gif') !== false)
                                                    <img src="{{ $p->media }}" alt="media gambar"
                                                        class="img-fluid lazyload" style="min-width: 100px; height: 100px;">
                                                @else
                                                    @if (filter_var($p->media, FILTER_VALIDATE_URL))
                                                        <div>
                                                            <a href="{{ $p->media }}" target="_blank"
                                                                class="btn btn-primary btn-sm">Read
                                                                Article
                                                                or
                                                                View
                                                                Material</a>
                                                        </div>
                                                    @else
                                                        <p>Unsupported media type or URL.</p>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $p->like }}</td>
                                            <td>{{ $p->komen }}</td>
                                            <td>
                                                <a href="{{ route('post.edit', $p->id) }}" class="btn btn-sm btn-info"><i
                                                        class="fa fa-pencil-alt"></i></a>
                                                <a href="{{ route('post.lihat', $p->id) }}"
                                                    class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('post.delete', $p->id) }}"
                                                    onclick="return confirmDelete()" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        function confirmDelete() {
            if (confirm("Apakah kamu yakin ingin menghapus?")) {
                console.log("Delete confirmed!");
                return true;
            } else {
                console.log("Delete canceled!");
                return false;
            }
        }
    </script>
@endpush
