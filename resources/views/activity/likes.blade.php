@extends('layout.app')

@section('title', 'Likes - PT Mustika Jaya Lestari')

@section('navbar-item')
    <a href="{{ route('activity') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <h5 class="text-center" style="color: black;"><i class="fa fa-heart" style="color: red;"></i>&nbsp;&nbsp;Likes
                </h5>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">No</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Media</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($likes as $item)
                            <tr class="text-center" style="color: black;">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->judul }}</td>
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
                                                '/(youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/',
                                                $item->media,
                                                $matches,
                                            );
                                            $youtubeId = $matches[2];
                                        @endphp
                                        <div class="d-none d-sm-block">
                                            <iframe style="max-width: 300px; min-width: 300px; height: auto;"
                                                src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen class="img-fluid lazyload"></iframe>
                                        </div>
                                        <div class="d-block d-sm-none">
                                            <iframe style="max-width: 300px; min-width: 300px; height: auto;"
                                                src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen class="img-fluid lazyload"></iframe>
                                        </div>
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
                                        @else
                                            <p>Unsupported media type or URL.</p>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('post.lihat', $item->id) }}" class="btn btn-sm btn-warning"><i
                                            class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $likes->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
