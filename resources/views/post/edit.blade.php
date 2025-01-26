@extends('layout.app')

@section('title', 'Edit - Pendarasa')

@php
    $no = 1;
@endphp

@section('content')
    <div class="row justify-content-center">
        <div class="col col-18 col-md-9">
            <div class="card">
                <div class="card-body">
                    <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-warning"><i
                            class="fa fa-arrow-left"></i>&nbsp;Batal</a>
                    <div class="text-center">
                        <h4 style="color: black; font-weight: bold;">Post</h4>
                    </div>
                    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
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
                            <textarea name="deskripsi" class="form-control" rows="8" required>{{ $post->deskripsi }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </form>
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
