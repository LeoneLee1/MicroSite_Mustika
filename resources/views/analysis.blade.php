@extends('layout.app')

@section('title', 'Analysis - Pendarasa')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-lg-7 col-md-6 col-12">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Hello {{ Auth::user()->nama }}! 🎉</h5>
                            @foreach ($total_post as $item)
                                <p class="mb-4">
                                    You have post <span class="fw-bold">{{ $item->total }}</span>&nbsp;media.
                                </p>
                            @endforeach
                            <a href="{{ route('beranda') }}" class="btn btn-sm btn-outline-primary">View Post Media</a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-12 text-center">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template-free/assets/img/illustrations/man-with-laptop.png"
                                height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
            <div class="card h-100">
                {{-- <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Posting Media</h5>
                        @foreach ($total_postingan as $t)
                            <small class="text-muted">{{ $t->total_post }} Total Post</small>
                        @endforeach
                    </div>
                </div> --}}
                <div class="card-body">
                    <div class="card-body d-flex justify-content-center align-items-center flex-column">
                        @foreach ($total_like as $l)
                            <h2 class="mb-2">{{ $l->total_like }}</h2>
                            <span>Total Likes in Every Media</span>
                        @endforeach
                    </div>
                    <p class="mb-3">Top Media :</p>
                    <ul class="p-0 m-0 list-unstyled">
                        @foreach ($lastest_post_like as $last)
                            <li class="d-flex mb-4 pb-1 border-bottom">
                                <div class="avatar flex-shrink-0 me-3">
                                    @if ($last->foto == '' || null)
                                        <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                            alt="Avatar" class="w-px-40 h-auto rounded-circle lazyload"></span>
                                    @else
                                        <img src="{{ asset('img/foto/' . $last->foto) }}" alt="Avatar"
                                            class="w-px-40 h-40 rounded-circle lazyload">
                                    @endif
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <a href="{{ route('post.lihat', $last->id) }}">
                                            <h6 class="mb-0" title="{{ $last->judul }}">
                                                {!! Str::limit($last->judul, 15, '....') !!}
                                            </h6>
                                            <small class="text-muted">{{ $last->nama }}</small>
                                        </a>
                                    </div>
                                    <div class="user-progress">
                                        <small class="fw-semibold">{{ $last->like }} Likes</small>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{-- ///////////// --}}
        {{-- TOTAL COMMENT --}}
        <div class="col-md-6 col-lg-4 order-1 mb-4">
            <div class="card h-100">
                {{-- <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Posting Media</h5>
                        @foreach ($total_postingan as $t)
                            <small class="text-muted">{{ $t->total_post }} Total Post</small>
                        @endforeach
                    </div>
                </div> --}}
                <div class="card-body">
                    <div class="card-body d-flex justify-content-center align-items-center flex-column">
                        @foreach ($total_comment as $c)
                            <h2 class="mb-2">{{ $c->total_komen }}</h2>
                            <span>Total Comments in Every Media</span>
                        @endforeach
                    </div>
                    <p class="mb-3">Top Media :</p>
                    <ul class="p-0 m-0 list-unstyled">
                        @foreach ($lastest_post_comment as $last)
                            <li class="d-flex mb-4 pb-1 border-bottom">
                                <div class="avatar flex-shrink-0 me-3">
                                    @if ($last->foto == '' || null)
                                        <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                            alt="Avatar" class="w-px-40 h-auto rounded-circle lazyload"></span>
                                    @else
                                        <img src="{{ asset('img/foto/' . $last->foto) }}" alt="Avatar"
                                            class="w-px-40 h-40 rounded-circle lazyload">
                                    @endif
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <a href="{{ route('post.lihat', $last->id) }}">
                                            <h6 class="mb-0" title="{{ $last->judul }}">
                                                {!! Str::limit($last->judul, 15, '....') !!}
                                            </h6>
                                            <small class="text-muted">{{ $last->nama }}</small>
                                        </a>
                                    </div>
                                    <div class="user-progress">
                                        <small class="fw-semibold">{{ $last->komen }} Comments</small>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{-- //////////// --}}
        {{-- TOTAL VOTING --}}
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
                {{-- <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Posting Media</h5>
                        @foreach ($total_postingan as $t)
                            <small class="text-muted">{{ $t->total_post }} Total Post</small>
                        @endforeach
                    </div>
                </div> --}}
                <div class="card-body">
                    <div class="card-body d-flex justify-content-center align-items-center flex-column">
                        @foreach ($total_voting as $v)
                            <h2 class="mb-2">{{ $v->total_vote }}</h2>
                            <span>Total Voting in Every Media</span>
                        @endforeach
                    </div>
                    <p class="mb-3">Top Media :</p>
                    <ul class="p-0 m-0 list-unstyled">
                        @foreach ($lastest_post_voting as $last)
                            <li class="d-flex mb-4 pb-1 border-bottom">
                                <div class="avatar flex-shrink-0 me-3">
                                    @if ($last->foto == '' || null)
                                        <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                            alt="Avatar" class="w-px-40 h-auto rounded-circle lazyload"></span>
                                    @else
                                        <img src="{{ asset('img/foto/' . $last->foto) }}" alt="Avatar"
                                            class="w-px-40 h-40 rounded-circle lazyload">
                                    @endif
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <a href="{{ route('post.lihat', $last->id) }}">
                                            <h6 class="mb-0" title="{{ $last->judul }}">
                                                {!! Str::limit($last->judul, 15, '....') !!}
                                            </h6>
                                            <small class="text-muted">{{ $last->nama }}</small>
                                        </a>
                                    </div>
                                    <div class="user-progress">
                                        <small class="fw-semibold">{{ $last->voting }} Votes</small>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
