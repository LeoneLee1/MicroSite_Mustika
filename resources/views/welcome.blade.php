@extends('layout.app')

@section('title', 'Polling Web - PT Mustika Jaya Lestari')

@push('after-style')
    <style>
        #more {
            display: none;
        }
    </style>
@endpush

@section('content')

@section('content')
    <div class="card">
        <div class="card-body">
            @foreach ($post as $item)
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-left d-none d-sm-block">
                        <strong style="color: black;">
                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                alt class="w-px-50 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                        </strong>&nbsp;&nbsp;•
                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                    </div>
                    <div class="text-left d-block d-sm-none">
                        <strong style="color: black;">
                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                alt class="w-px-50 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                        </strong>
                        {{-- {{ \Carbon\Carbon::parse($item->created_at)->format('d M') }} --}}
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-dark" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#"><i
                                        class="fas fa-circle-user menu-icon"></i>&nbsp;About This
                                    Account</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i
                                        class="fa fa-bookmark menu-icon"></i>&nbsp;Save</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye-slash"></i>&nbsp;&nbsp;Hide</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-flag"
                                        style="color: red;"></i>&nbsp;&nbsp;Report</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="text-center">
                    @if (strpos($item->media, '.mp4') !== false ||
                            strpos($item->media, '.webm') !== false ||
                            strpos($item->media, '.ogg') !== false)
                        <video controls class="img-fluid">
                            <source src="{{ $item->media }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @elseif (strpos($item->media, 'youtube.com') !== false || strpos($item->media, 'youtu.be') !== false)
                        @php
                            preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/', $item->media, $matches);
                            $youtubeId = $matches[2];
                        @endphp
                        <div class="d-none d-sm-block">
                            <iframe style="max-width: 1000px; min-width: 1000px; height: 350px;"
                                src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen class="img-fluid lazyload"></iframe>
                        </div>
                        <div class="d-block d-sm-none">
                            <iframe style="max-width: 260px; min-width: 260px; height: 200px;"
                                src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen class="img-fluid lazyload"></iframe>
                        </div>
                    @elseif (strpos($item->media, '.jpg') !== false ||
                            strpos($item->media, '.jpeg') !== false ||
                            strpos($item->media, '.png') !== false ||
                            strpos($item->media, 'data:image') !== false ||
                            strpos($item->media, '.gif') !== false)
                        <img src="{{ $item->media }}" alt="media gambar" class="img-fluid lazyload">
                    @else
                        @if (filter_var($item->media, FILTER_VALIDATE_URL))
                            <div>
                                <a href="{{ $item->media }}" target="_blank" class="btn btn-primary btn-sm">Read
                                    Article
                                    or
                                    View
                                    Material</a>
                            </div>
                        @else
                            <p>Unsupported media type or URL.</p>
                        @endif
                    @endif
                </div>
                <div class="text-left mt-4 mb-4">
                    <h5 style="color: black;">{{ $item->judul }}</h5>
                </div>
                <div class="text-left mt-4">
                    <span style="color: black;">
                        <span class="short-text">
                            {!! nl2br(e(Str::limit($item->deskripsi, 500))) !!}
                        </span>
                        <span class="full-text" style="display: none;">
                            {!! nl2br(e($item->deskripsi)) !!}
                        </span>
                        <a href="javascript:void(0);" class="view-more" style="display: none; color: red;">View More</a>
                    </span>
                </div>

                <div class="mt-4">
                    <div class="text-left">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">View
                            All
                            Comments</a>
                        @include('modal.comments')
                    </div>
                </div>
                <div class="mt-3">
                    <small>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</small>
                    {{-- &nbsp;&nbsp;• --}}
                    {{-- <a href="javascript:void(0);" onclick="translateToIndonesian({{ $item->id }})">See Translation</a> --}}
                </div>
            @endforeach
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
@push('after-script')
    <script>
        $(document).ready(function() {
            $('.text-left').each(function() {
                var fullText = $(this).find('.full-text');
                var shortText = $(this).find('.short-text');
                var viewMoreLink = $(this).find('.view-more');

                if (fullText.text().length > 500) {
                    viewMoreLink.show();
                } else {
                    shortText.text(fullText.text()); // Menampilkan teks penuh jika kurang dari 500 karakter
                }
            });

            $('.view-more').click(function() {
                var shortText = $(this).siblings('.short-text');
                var fullText = $(this).siblings('.full-text');

                if (shortText.is(':visible')) {
                    shortText.hide();
                    fullText.show();
                    $(this).text('View Less');
                } else {
                    shortText.show();
                    fullText.hide();
                    $(this).text('View More');
                }
            });
        });
    </script>
@endpush
