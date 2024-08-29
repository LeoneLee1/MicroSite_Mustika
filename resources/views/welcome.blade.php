@extends('layout.app')

@section('title', 'Polling Web - PT Mustika Jaya Lestari')

@section('content')

@section('content')
    <div class="card">
        <div class="card-body">
            @foreach ($post as $item)
                <div class="text-left">
                    <strong style="color: black;"><img
                            src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}" alt
                            class="w-px-50 h-auto rounded-circle" />&nbsp;{{ $item->nama }}</strong>&nbsp;&nbsp;•
                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                </div>
                <div class="text-center">
                    @if (strpos($item->media, '.mp4') !== false ||
                            strpos($item->media, '.webm') !== false ||
                            strpos($item->media, '.ogg') !== false)
                        <video controls class="img-fluid">
                            <source src="{{ $item->media }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <img src="{{ $item->media }}" alt="media gambar" class="img-fluid">
                    @endif
                </div>
                <div class="text-left mt-4">
                    <span id="description-{{ $item->id }}" style="color: black;">
                        {!! nl2br(e($item->deskripsi)) !!}
                    </span>
                </div>
                <div class="mt-4">
                    <div class="text-left">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">View All
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
