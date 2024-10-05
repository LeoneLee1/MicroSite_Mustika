@extends('layout.app')

@section('title', 'Posts - PT Mustika Jaya Lestari')

@section('navbar-item')
    <a href="{{ route('activity') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
@endsection

@section('content')
    <div class="card">
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
                                                <img src="{{ $p->media }}" alt="media gambar" class="img-fluid lazyload"
                                                    style="min-width: 100px; height: 100px;">
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
                                            <a href="{{ route('post.lihat', $p->id) }}" class="btn btn-sm btn-warning"><i
                                                    class="fa fa-eye"></i></a>
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
@endsection
