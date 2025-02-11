@extends('layout.app')

@section('title', 'Pendarasa')

@push('after-style')
    @include('components.beranda.style')
@endpush


@section('navbar-item')
    <a href="{{ route('ai') }}" target="_blank">
        <div class="d-inline">
            <i class="fa fa-robot me-1"></i>
            <span>Ask AI</span>
        </div>
    </a>
@endsection

@include('modal.cariPost')
@include('modal.menyukai')
@section('content')
    @if (Auth::user()->no_hp === null || Auth::user()->no_hp === '')
        <!-- Modal -->
        <div class="modal fade" id="autoShowModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h6 class="modal-title" id="modalLabel" style="color: #000000; font-weight: bold;">Mohon untuk
                            memasukkan nomor HP yang
                            aktif dan dapat
                            dihubungi
                            sebagai syarat untuk mengakses website Pendarrasa. Terima kasih atas pengertiannya.</h6>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('beranda.insertNomorHp') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Nomor HP (Whatsapps / Telegram)</label>
                                <input type="number" name="no_hp" class="form-control" placeholder="08123123222">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($post as $item)
                @include('modal.akun')
                <div class="card mb-3" style="width: 55rem;">
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                @if ($item->foto == '' || null)
                                    <div class="text-left d-none d-sm-block" data-bs-toggle="modal"
                                        data-bs-target="#akun{{ $item->id }}" style="cursor: pointer;">
                                        <strong style="color: black;">
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt
                                                class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;{{ $item->nama }}
                                        </strong>&nbsp;&nbsp;•
                                        {{ \Carbon\Carbon::parse($item->time_post)->diffForHumans() }}
                                    </div>
                                    <div class="text-left d-block d-sm-none" data-bs-toggle="modal"
                                        data-bs-target="#akun{{ $item->id }}" style="cursor: pointer;">
                                        <strong style="color: black;">
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt
                                                class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;{{ $item->nama }}
                                        </strong>
                                    </div>
                                @else
                                    <div class="text-left d-none d-sm-block" data-bs-toggle="modal"
                                        data-bs-target="#akun{{ $item->id }}" style="cursor: pointer;">
                                        <strong style="color: black;">
                                            <img src="{{ asset('img/foto/' . $item->foto) }}" alt
                                                class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                                        </strong>&nbsp;&nbsp;•
                                        {{ \Carbon\Carbon::parse($item->time_post)->diffForHumans() }}
                                    </div>
                                    <div class="text-left d-block d-sm-none" data-bs-toggle="modal"
                                        data-bs-target="#akun{{ $item->id }}" style="cursor: pointer;">
                                        <strong style="color: black;">
                                            <img src="{{ asset('img/foto/' . $item->foto) }}" alt
                                                class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                                        </strong>
                                    </div>
                                @endif
                                <div class="dropdown">
                                    <button class="btn btn-link text-dark" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#"
                                                onclick="return save({{ $item->id }})"><i
                                                    class="fas fa-bookmark menu-icon"
                                                    style="color: rgb(105, 105, 247)"></i>&nbsp;Simpan</a></li>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="slide-container" id="slide-container-{{ $item->id }}">
                                    @foreach ($post_gambar as $row)
                                        @if ($row->id_post == $item->id)
                                            <div class="mySlides" data-slide-id="{{ $item->id }}">
                                                @if (strpos($row->media, '.mp4') !== false ||
                                                        strpos($row->media, '.webm') !== false ||
                                                        strpos($row->media, '.ogg') !== false)
                                                    <video controls class="img-fluid" style="max-width: 50%; height: auto;">
                                                        <source src="{{ asset('media/' . $row->media) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @elseif (strpos($row->media, 'youtube.com') !== false || strpos($row->media, 'youtu.be') !== false)
                                                    @php
                                                        preg_match(
                                                            '/(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/)([^\&\?\/]+)/',
                                                            $row->media,
                                                            $matches,
                                                        );
                                                        $youtubeId = $matches[3] ?? null;
                                                    @endphp
                                                    @if ($youtubeId)
                                                        <div class="d-none d-sm-block">
                                                            <iframe
                                                                style="max-width: 750px; min-width: 750px; height: 350px;"
                                                                src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen class="img-fluid lazyload"></iframe>
                                                        </div>
                                                        <div class="d-block d-sm-none">
                                                            <iframe
                                                                style="max-width: 260px; min-width: 260px; height: 200px;"
                                                                src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen class="img-fluid lazyload"></iframe>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if ($row->media === null)
                                                    @else
                                                        <a href="{{ asset('media/' . $row->media) }}">
                                                            <img src="{{ asset('media/' . $row->media) }}"
                                                                alt="media gambar" class="img-fluid lazyload"
                                                                style="height: 300px;">
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                    <a class="prev" onclick="plusSlides(-1, {{ $item->id }})">
                                        <span style="color: #ffffff;">&#10094;</span>
                                    </a>
                                    <a class="next" onclick="plusSlides(1, {{ $item->id }})">
                                        <span style="color: #ffffff;">&#10095;</span>
                                    </a>
                                </div>
                            </div>
                            <div class="text-left mt-4">
                                <h5 style="color: black; font-weight: bold;">{{ $item->judul }}</h5>
                            </div>
                            <div class="d-flex justify-content-start">
                                @if (Auth::user()->role == 'Pengamat')
                                    <div class="d-flex align-items-center me-3">
                                        <i class="fa fa-heart" style="font-size: 1.70em; color: grey;"></i>
                                    </div>
                                    <div class="d-flex align-items-center me-3">
                                        <a href="{{ route('comment', $item->id) }}">
                                            <i class="fa fa-comment" style="font-size: 1.70em; color: #696cff;"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center me-3">
                                        <i class="fa fa-heart me-2 like-button" id="like-button{{ $item->id }}"
                                            data-post-id="{{ $item->id }}"
                                            style="font-size: 1.70rem; cursor: pointer; color: {{ Auth::user()->hasLiked($item->id) ? 'red' : 'grey' }};">
                                        </i>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#menyukai{{ $item->id }}">
                                            <span style="color: black; font-weight: bold;"
                                                id="like-count{{ $item->id }}">{{ $item->like }}</span>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center me-3">
                                        <a href="{{ route('comment', $item->id) }}">
                                            <i class="fa fa-comment" style="font-size: 1.70em; color: #696cff;"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('analyze', $item->id) }}" class="btn btn-sm btn-danger"
                                            onclick="askAI()" id="buttonTanyaAI">Tanya
                                            AI</a>
                                        <button class="buttonload btn btn-danger" style="display: none;">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="text-left mt-2">
                                @php
                                    $fullText = $item->deskripsi;
                                    $truncated = Str::limit(strip_tags($fullText), 500, '...');
                                    $isLong = strlen(strip_tags($fullText)) > 500;
                                    $uniqueId = 'description-' . $item->id;
                                @endphp
                                <div id="shortText-{{ $uniqueId }}" style="color: black;">
                                    {!! $truncated !!}
                                </div>
                                <div id="fullText-{{ $uniqueId }}" style="color: black; display: none;">
                                    {!! $fullText !!}
                                </div>
                                @if ($isLong)
                                    <a href="javascript:void(0);" onclick="toggleText('{{ $uniqueId }}')"
                                        id="readMoreBtn-{{ $uniqueId }}" style="color: red;">
                                        Baca Selengkapnya
                                    </a>
                                @endif
                            </div>
                            <div class="mt-1">
                                <div class="text-left">
                                    <a href="{{ route('comment', $item->id) }}">Lihat semua
                                        {{ $item->komen }}
                                        komentar</a>
                                </div>
                            </div>
                            <div class="d-flex row justify-content-start align-items-center mt-2">
                                @php $count = 0; @endphp
                                @foreach ($komen as $k)
                                    @if ($k->id_post === $item->id)
                                        @php $count++; @endphp
                                        @if ($count <= 1)
                                            <div style="color: black;" class="mb-2">
                                                <span style="font-weight: bold;">
                                                    {{ $k->nama }}
                                                </span>{{ $k->comment }}
                                            </div>
                                        @else
                                        @break
                                    @endif
                                @endif
                            @endforeach
                            @if (Auth::user()->role == 'Pengamat')
                            @else
                                <div class="mt-2">
                                    <div class="d-flex justify-content-start">
                                        <form method="POST" action="{{ route('comment.insert') }}"
                                            enctype="multipart/form-data"
                                            class="d-flex align-items-left w-100 comment-form">
                                            @csrf
                                            <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                                            <input type="hidden" name="id_post" value="{{ $item->id }}">
                                            <div class="input-group me-2" style="flex: 1;">
                                                <span class="input-group-text bg-white border-0 p-0"
                                                    id="basic-addon1">
                                                    @if (Auth::user()->foto == '' || null)
                                                        <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                            alt="User Avatar"
                                                            class="w-px-40 h-auto rounded-circle lazyload"
                                                            style="object-fit: cover;" />
                                                    @else
                                                        <img src="{{ asset('img/foto/' . Auth::user()->foto) }}"
                                                            alt="User Avatar"
                                                            class="w-px-40 h-auto rounded-circle lazyload"
                                                            style="object-fit: cover;" />
                                                    @endif
                                                </span>
                                                <div class="image-preview-container" id="imagePreviewContainer"
                                                    style="display: none;">
                                                    <div class="image-preview-wrapper">
                                                        <img id="imagePreview" src="" alt="Preview">
                                                        <button type="button" class="remove-image"
                                                            onclick="removeImage()">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <textarea name="comment" class="form-control" style="border-radius: 50px; margin-left: 10px;" id="komentar"
                                                    rows="1" placeholder="Add Comments...." required></textarea>
                                            </div>
                                            <input type="file" name="clip" id="buttonFile" hidden>
                                            <button type="button" class="btn btn-danger btn-sm me-1"
                                                title="PICTURE/VIDEO" style="border-radius: 50px;"
                                                onclick="document.getElementById('buttonFile').click();"><i
                                                    class="fa fa-paperclip"></i></button>
                                            <button type="submit" class="btn btn-primary btn-sm me-2"
                                                style="border-radius: 50px;">Send</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-3">
                                <small>{{ \Carbon\Carbon::parse($item->time_post)->format('d M Y') }}</small>
                            </div>
                            <div class="mt-4">
                                @foreach ($poll as $p)
                                    @if ($p->id_post == $item->id)
                                        <div class="text-center mb-4">
                                            <h4 style="font-weight: bold; color: black;">
                                                {{ $p->soal }}
                                            </h4>
                                        </div>
                                        <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    @foreach ($jawaban as $a)
                                                        @if ($a->id_post == $item->id && $a->poll_id == $p->id)
                                                            @php
                                                                $userVotedPoll = DB::table('answer_vote')
                                                                    ->where('nik', Auth::user()->nik)
                                                                    ->where('poll_id', $a->poll_id)
                                                                    ->exists();

                                                                $userVote = DB::table('answer_vote')
                                                                    ->where('nik', Auth::user()->nik)
                                                                    ->where('poll_id', $a->poll_id)
                                                                    ->where('id_post', $a->id_post)
                                                                    ->where('id_jawaban', $a->id)
                                                                    ->exists();
                                                            @endphp
                                                            <div
                                                                class="mb-2 d-flex justify-content-between align-items-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="vote{{ $a->id }}"
                                                                        data-answer-id="{{ $a->id }}"
                                                                        data-poll-id="{{ $a->poll_id }}"
                                                                        data-post-id="{{ $a->id_post }}"
                                                                        data-answer="{{ $a->jawaban }}"
                                                                        {{ $userVotedPoll ? 'disabled' : '' }}
                                                                        {{ $userVote ? 'checked' : '' }}>
                                                                    @if (Auth::user()->role === 'Pengamat')
                                                                        <input type="radio" class="form-check-input"
                                                                            disabled>
                                                                    @endif
                                                                    <label
                                                                        class="form-check-label">{{ $a->jawaban }}</label>
                                                                </div>
                                                                <span class="badge bg-primary"
                                                                    id="vote-count{{ $a->id }}">{{ $a->value }}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @foreach ($poll as $p)
                                                    @if ($p->id_post == $item->id)
                                                        <div class="col-md-4">
                                                            <div style="position: relative; height:250px; width:100%;">
                                                                <canvas id="myChart{{ $p->id }}"></canvas>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @foreach ($poll as $p)
                                            @if ($p->id_post == $item->id)
                                                <div class="text-center mb-4">
                                                    <a href="{{ route('viewVote', $p->id) }}"
                                                        class="btn btn-success">View
                                                        votes</a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center mt-3">
            <div class="card" style="width: 55rem;">
                <div class="card-body">
                    {{ $post->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    <div class="d-block d-sm-none">
        <button id="refreshButton" class="refresh-button"data-bs-toggle="modal" data-bs-target="#searchPost"><i
                class="fa fa-search"></i></button>
    </div>
@endsection

@push('after-script')
    @include('components.beranda.script')
@endpush
