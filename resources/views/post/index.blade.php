@extends('layout.app')

@section('title', 'Buat Post - Pendarasa')

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
        <div class="col col-18 col-md-9">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" placeholder="Judul" class="form-control" required>
                        </div>
                        <div id="media-wrapper">
                            <div class="mb-3" id="media-slide-1">
                                <label class="form-label">Media</label>
                                <div class="mb-2">
                                    <label>
                                        <input type="radio" name="input_type1" onclick="toggleInput(1, 'text')" checked>
                                        Isi Link
                                    </label>
                                    <label>
                                        <input type="radio" name="input_type1" onclick="toggleInput(1, 'file')">
                                        Unggah File
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="media[]" id="text_input_div1" placeholder="Link URL Youtube"
                                        class="form-control">
                                    <input type="file" name="media[]" id="file_input_div1" class="form-control"
                                        style="display: none;">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm mb-4" id="add-media-button">Tambah
                            Media</button>
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
        let mediaCount = 1;

        $('#add-media-button').click(function() {
            mediaCount++;
            let newMedia = `<div class="mb-3" id="media-slide-${mediaCount}">
                        <label class="form-label">Media ${mediaCount - 1}</label>
                        <div class="mb-2">
                            <label>
                                <input type="radio" name="input_type${mediaCount}" onclick="toggleInput(${mediaCount}, 'text')" checked>
                                Isi Link
                            </label>
                            <label>
                                <input type="radio" name="input_type${mediaCount}" onclick="toggleInput(${mediaCount}, 'file')">
                                Unggah File
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="media[]" id="text_input_div${mediaCount}" placeholder="Link URL Youtube" class="form-control">
                            <input type="file" name="media[]" id="file_input_div${mediaCount}" class="form-control" style="display: none;">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-media-button" data-media-id="${mediaCount}">Hapus Media</button>
                        </div>
                    </div>`;
            $('#media-wrapper').append(newMedia);
        });

        $(document).on('click', '.remove-media-button', function() {
            let mediaId = $(this).data('media-id');
            $('#media-slide-' + mediaId).remove();
        });

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

        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons lists searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
@endpush
