@extends('layout.app')

@section('title', 'Post - Pendarasa')

@push('after-style')
    <style>
        .text-danger {
            color: red;
        }

        textarea.form-control {
            white-space: pre-wrap;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.insert') }}" method="POST" enctype="multipart/form-data" id="myForm">
                        @csrf
                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" placeholder="Judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Media</label>
                            <input type="text" name="media" placeholder="Link URL Youtube/Article/Image"
                                class="form-control">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#panduan" style="margin-left: 2px;">
                                <small>Panduan Media Link (Click Here!)</small>
                                @include('modal.panduan')
                            </a>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="8" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" name="polling" id="pollingCheck" value="">
                            <label class="form-check-label" for="pollingCheck">
                                Polling?
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection

@push('after-script')
    <script src="https://cdn.tiny.cloud/1/fermvmni7gzbmep9r0j3sek3jmb2mbkko0ekabe63b26alyx/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons lists searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            setup: function(editor) {
                editor.on('input', function() {
                    const maxChars = 3000;
                    const content = editor.getContent({
                        format: 'text'
                    });
                    if (content.length > maxChars) {
                        editor.setContent(content.slice(0, maxChars));
                        alert('Jumlah karakter maksimum adalah 3000.');
                    }
                });
            }
        });
    </script>
@endpush
