@extends('layout.app')

@section('title', 'Edit Media - Pendarrasa')

@push('after-style')
    <style>
        .back-button {
            background-color: #ffffff;
            color: #6366f1;
            border: 2px solid #6366f1;
            border-radius: 20px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-button:hover {
            background-color: #6366f1;
            color: white;
        }
    </style>
@endpush

@section('navbar-item')
    <a href="{{ route('post.edit', $item->id_post) }}" class="back-button btn-sm">
        <i class="fa fa-arrow-left"></i>
        <span class="d-none d-sm-block">Back</span>
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col col-18 col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        @if (strpos($item->media, '.mp4') !== false ||
                                strpos($item->media, '.webm') !== false ||
                                strpos($item->media, '.ogg') !== false)
                            <video controls class="img-fluid" style="max-width: 50%; height: auto;">
                                <source src="{{ asset('media/' . $item->media) }}" type="video/mp4">
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
                                    <iframe style="width: 500px; height: 250px;"
                                        src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen class="img-fluid lazyload"></iframe>
                                </div>
                                <div class="d-block d-sm-none">
                                    <iframe style="max-width: 250px; min-width: 150px; height: 200px;"
                                        src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen class="img-fluid lazyload"></iframe>
                                </div>
                            @endif
                        @else
                            @if ($item->media === null)
                            @else
                                <a href="{{ asset('media/' . $item->media) }}">
                                    <img src="{{ asset('media/' . $item->media) }}" alt="media gambar"
                                        class="img-fluid lazyload" style="height: 300px;">
                                </a>
                            @endif
                        @endif
                    </div>
                    <div class="mt-4">
                        <form action="{{ route('post.slideUpdate', $item->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <label class="form-label">New Media Or Update</label>
                            <div class="mb-2">
                                <label>
                                    <input type="radio" name="input_type" onclick="toggleInput('text')" checked>
                                    Isi Link
                                </label>
                                <label>
                                    <input type="radio" name="input_type" onclick="toggleInput('file')">
                                    Unggah File
                                </label>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="media" id="text_input_div" placeholder="Link URL Youtube"
                                    class="form-control">
                                <input type="file" name="media" id="file_input_div" class="form-control"
                                    style="display: none;">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('after-script')
    <script>
        function toggleInput(type) {
            if (type === 'text') {
                document.getElementById(`text_input_div`).style.display = 'block';
                document.getElementById(`file_input_div`).style.display = 'none';
                document.getElementById(`file_input_div`).value = '';
            } else if (type === 'file') {
                document.getElementById(`text_input_div`).style.display = 'none';
                document.getElementById(`file_input_div`).style.display = 'block';
                document.getElementById(`text_input_div`).value = '';
            }
        }
    </script>
@endpush
