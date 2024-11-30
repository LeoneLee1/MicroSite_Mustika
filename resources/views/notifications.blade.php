@extends('layout.app')

@section('title', 'Notifcation - Pendarrasa')

@section('navbar-item')
    <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-sm btn-info"><i
            class="fa fa-arrow-left"></i>&nbsp;Back</a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-18 col-md-9">
                <div class="card">
                    <div class="card-header" style="color: black; font-weight: bold;">Notifications</div>
                    <div class="card-body">
                        <div style="max-height: 450px; overflow-y: auto; padding-right: 15px;">
                            @if ($notif_post_all === null || collect($notif_post_all)->isEmpty())
                                <div class="text-center mb-4">
                                    <h2>No Notifications</h2>
                                </div>
                            @endif
                            @foreach ($notif_post_all as $item)
                                <div class="d-flex align-items-center justify-content-between" style="margin-bottom: 10px;">
                                    <div class="d-flex align-items-center">
                                        <div class="text-left">
                                            @if ($item->foto === '' || null)
                                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                    alt class="w-px-40 h-auto rounded-circle lazyload" />
                                            @else
                                                <img src="{{ asset('img/foto/' . $item->foto) }}" alt
                                                    class="w-px-40 h-auto rounded-circle lazyload" />
                                            @endif
                                        </div>
                                        <div class="ms-2">
                                            <a href="{{ route('post.lihat', $item->id_post) }}">
                                                <span href="javascript:void(0)"
                                                    style="color: black; font-weight: bold; display: inline;">
                                                    {{ $item->nama }}
                                                </span>
                                                <span style="color: black;">{{ $item->info }}</span>
                                                <span
                                                    style="color: black; font-weight: bold;">{{ $item->judul ?? ($item->comment ?? $item->commentReplies) }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-inline-flex" style="margin-left: 40px;">
                                        <p style="margin-right: 10px;">
                                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
