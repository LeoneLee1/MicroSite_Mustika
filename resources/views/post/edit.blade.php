@extends('layout.app')

@section('title', 'Edit - Pendarasa')

@php
    $no = 1;
@endphp

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
    <a href="javascript:void(0)" class="back-button btn-sm" onclick="window.history.go(-1); return false;">
        <i class="fa fa-arrow-left"></i>
        <span class="d-none d-sm-block">Back</span>
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col col-18 col-md-9">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.update', $post->id) }}" method="POST" name="myForm">
                        @csrf
                        <div class="mb-3">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{ $post->judul }}">
                        </div>
                        <label class="form-label">Media</label>
                        <div class="mb-3">
                            @foreach ($media as $item)
                                @if ($item->media === null)
                                @else
                                    <div class="d-inline">
                                        <a href="/post/slide/edit/{{ $item->id }}"
                                            class="btn btn-sm btn-primary me-1">Slide
                                            {{ $no++ }}</a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" cols="30" rows="8">{!! $post->deskripsi !!}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                    {{-- <form action="{{ route('post.update', $post->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{ $post->judul }}">
                        </div>
                        <label class="form-label">Media</label>
                        <div class="d-flex d-inline">
                            @foreach ($media as $item)
                                <div class="mb-3 me-2">
                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#slideMediaEdit{{ $item->id }}">Slide {{ $no++ }}</a>
                                    @include('modal.slideMediaEdit')
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="8">{{ $post->deskripsi }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script src="https://cdn.tiny.cloud/1/fermvmni7gzbmep9r0j3sek3jmb2mbkko0ekabe63b26alyx/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        function toggleInput(id, type) {
            if (type === 'text') {
                document.getElementById(`text_input_div${id}`).style.display = 'block';
                document.getElementById(`file_input_div${id}`).style.display = 'none';
                document.getElementById(`file_input_div${id}`).value = '';
            } else if (type === 'file') {
                document.getElementById(`text_input_div${id}`).style.display = 'none';
                document.getElementById(`file_input_div${id}`).style.display = 'block';
                document.getElementById(`text_input_div${id}`).value = '';
            }
        }
    </script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons lists searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
@endpush
