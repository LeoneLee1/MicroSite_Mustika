@extends('layout.app')

@section('title', 'Edit - Pendarasa')

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
                        <div class="mb-3">
                            <label class="form-label">Media</label>
                            <div class="mb-2">
                                <label>
                                    <input type="radio" name="input_type" onclick="toggleInput('text')" checked>
                                    Isi Link
                                </label>
                                <label>
                                    <input type="radio" name="input_type" onclick="toggleInput('file')">
                                    Unggah File
                                </label>
                            </div>
                            <input type="text" name="media" id="text_input_div"
                                placeholder="Link URL Youtube/Article/Image" class="form-control"
                                value="{{ $post->media }}">
                            <input type="file" name="media_file" id="file_input_div" class="form-control"
                                style="display: none;">
                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#panduan" style="margin-left: 2px;">
                                <small>Panduan Media Link (Click Here!)</small>
                                @include('modal.panduan')
                            </a> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="8" required id="deskripsi">{{ $post->deskripsi }}</textarea>
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
        function toggleInput(type) {
            if (type === 'text') {
                document.getElementById('text_input_div').style.display = 'block';
                document.getElementById('file_input_div').style.display = 'none';
                document.getElementById('file_input_div').value = '';
            } else if (type === 'file') {
                document.getElementById('text_input_div').style.display = 'none';
                document.getElementById('file_input_div').style.display = 'block';
                document.getElementById('text_input_div').value = '';
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
