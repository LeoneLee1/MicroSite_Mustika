@extends('layout.app')

@section('title', 'Comments - PT Mustika Jaya Lestari')

@section('navbar-item')
    <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-info"><i
            class="fa fa-arrow-left"></i>&nbsp;Back</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <h5 class="text-center" style="color: black;"><i class="fa fa-comment"
                        style="color: #696cff;"></i>&nbsp;&nbsp;Comments
                </h5>
                @if ($comments === null || collect($comments)->isEmpty())
                    <div class="text-center mb-4">
                        <h2>No Comments yet</h2>
                    </div>
                @endif
                @foreach ($comments as $row)
                    <div class="comment">
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            @if ($row->foto_post == '' || null)
                                <div class="text-left d-none d-sm-block">
                                    <a href="{{ route('post.lihat', $row->id_post) }}" style="color: black;">
                                        <strong>
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt class="w-px-30 h-auto rounded-circle lazyload" />
                                            &nbsp;{{ $row->nama }}
                                        </strong>&nbsp;{!! Str::limit($row->judul, 15, '...') !!}
                                    </a>
                                    <div class="mb-4" style="margin-left: 35px;">
                                        -&nbsp;{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="text-left d-block d-sm-none">
                                    <a href="{{ route('post.lihat', $row->id_post) }}" style="color: black;">
                                        <strong>
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt class="w-px-30 h-auto rounded-circle lazyload" />
                                            &nbsp;{{ $row->nama }}
                                        </strong>&nbsp;{!! Str::limit($row->judul, 15, '...') !!}
                                    </a>
                                    <div>
                                        {{ \Carbon\Carbon::parse($row->created_at)->format('d M') }}
                                    </div>
                                </div>
                            @else
                                <div class="text-left d-none d-sm-block">
                                    <a href="{{ route('post.lihat', $row->id_post) }}" style="color: black;">
                                        <strong>
                                            <img src="{{ asset('img/foto/' . $row->foto_post) }}" alt
                                                class="w-px-30 h-auto rounded-circle lazyload" />
                                            &nbsp;{{ $row->nama }}
                                        </strong>&nbsp;{!! Str::limit($row->judul, 15, '...') !!}
                                    </a>
                                    <div class="mb-4" style="margin-left: 35px;">
                                        -&nbsp;{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="text-left d-block d-sm-none">
                                    <a href="{{ route('post.lihat', $row->id_post) }}" style="color: black;">
                                        <strong>
                                            <img src="{{ asset('img/foto/' . $row->foto_post) }}" alt
                                                class="w-px-30 h-auto rounded-circle lazyload" />
                                            &nbsp;{{ $row->nama }}
                                        </strong>&nbsp;{!! Str::limit($row->judul, 15, '...') !!}
                                    </a>
                                    <div>
                                        {{ \Carbon\Carbon::parse($row->created_at)->format('d M') }}
                                    </div>
                                </div>
                            @endif
                            @if (Auth::user()->nik == $row->nik)
                                <div class="dropdown">
                                    <button class="btn btn-link text-dark" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('comment.delete', $row->id) }}"
                                                onclick="return confirmDelete()"><i class="fa fa-trash menu-icon"
                                                    style="color: red;"></i>&nbsp;Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                            @endif
                        </div>
                        <div class="text-left" style="margin-left: 50px; color: black;">
                            @if (Auth::user()->foto == '' || null)
                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                    alt
                                    class="w-px-30 h-auto rounded-circle lazyload" />&nbsp;&nbsp;&nbsp;{{ Auth::user()->nama }}
                            @else
                                <img src="{{ asset('img/foto/' . Auth::user()->foto) }}" alt
                                    class="w-px-30 h-auto rounded-circle lazyload" />&nbsp;&nbsp;&nbsp;{{ Auth::user()->nama }}
                            @endif
                            <p style="margin-left: 55px;" class="mt-2">{!! nl2br(e($row->comment)) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
