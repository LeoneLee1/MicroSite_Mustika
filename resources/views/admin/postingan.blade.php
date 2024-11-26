@extends('layout.app')

@section('title', 'ADMIN DASHBOARD - PENDARRASA')

@php
    $no = 1;
@endphp

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NIK</th>
                                <th>NAMA</th>
                                <th>MEDIA</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($post as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        @if (strpos($item->media, '.mp4') !== false ||
                                                strpos($item->media, '.webm') !== false ||
                                                strpos($item->media, '.ogg') !== false)
                                            <video controls class="img-fluid">
                                                <source src="{{ $item->media }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @elseif (strpos($item->media, 'youtube.com') !== false || strpos($item->media, 'youtu.be') !== false)
                                            @php
                                                preg_match(
                                                    '/(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/)([^\&\?\/]+)/',
                                                    $item->media,
                                                    $matches,
                                                );
                                                $youtubeId = $matches[3] ?? null;
                                            @endphp
                                            @if ($youtubeId)
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
                                            @endif
                                        @elseif (strpos($item->media, '.jpg') !== false ||
                                                strpos($item->media, '.jpeg') !== false ||
                                                strpos($item->media, '.png') !== false ||
                                                strpos($item->media, 'data:image') !== false ||
                                                strpos($item->media, '.gif') !== false)
                                            <img src="{{ $item->media }}" alt="media gambar" class="img-fluid lazyload"
                                                style="min-width: 100px; height: 100px;">
                                        @else
                                            @if (filter_var($item->media, FILTER_VALIDATE_URL))
                                                <div>
                                                    <a href="{{ $item->media }}" target="_blank"
                                                        class="btn btn-primary btn-sm">Read
                                                        Article
                                                        or
                                                        View
                                                        Material</a>
                                                </div>
                                            @elseif($item->media_file !== null)
                                                <img src="{{ asset('media/' . $item->media_file) }}" alt="media gambar"
                                                    class="img-fluid lazyload" style="min-width: 100px; height: 100px;">
                                            @else
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('post.lihat', $item->id) }}" class="btn btn-sm btn-warning"><i
                                                class="fa fa-eye"></i></a>
                                        <a href="{{ route('post.edit', $item->id) }}" class="btn btn-sm btn-primary"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="{{ route('post.delete', $item->id) }}" onclick="return Delete()"
                                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $post->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        function Delete() {
            if (confirm('Delete?')) {
                return true
            } else {
                return false
            }
        }
    </script>
@endpush
