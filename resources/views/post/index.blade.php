@extends('layout.app')

@section('title', 'Post - Pendarasa')

@push('after-style')
    <style>
        .text-danger {
            color: red;
        }
    </style>
@endpush

@section('content')
    <div class="text-center" id="loading" style="margin-top: 240px;">
        <div class="spinner-border spinner-border-lg text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
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
                        {{-- <div class="mb-3">
                            <label class="form-label">Media</label>
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-success" onclick="showInput('text')">Link URL
                                    (Youtube/Article)</button>
                                <button type="button" class="btn btn-sm btn-warning" onclick="showInput('file')">File
                                    Upload</button>
                            </div>
                            <input type="text" name="media" class="form-control" placeholder="Link URL" id="textInput">
                            <input type="file" name="media_file" class="form-control" style="display: none;"
                                id="fileInput">
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="8" maxlength="1000" required id="deskripsi"></textarea>
                            <small id="charCount" class="form-text text-muted">0/1000</small>
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
    <script>
        function showInput(type) {
            if (type === 'text') {
                document.getElementById('textInput').style.display = 'block';
                document.getElementById('fileInput').style.display = 'none';
            } else if (type === 'file') {
                document.getElementById('textInput').style.display = 'none';
                document.getElementById('fileInput').style.display = 'block';
            }
        }
    </script>
    <script>
        const wait = (delay = 0) =>
            new Promise(resolve => setTimeout(resolve, delay));

        const setVisible = (elementOrSelector, visible) =>
            (typeof elementOrSelector === 'string' ?
                document.querySelector(elementOrSelector) :
                elementOrSelector
            ).style.display = visible ? 'block' : 'none';

        setVisible('.card', false);
        setVisible('#loading', true);

        document.addEventListener('DOMContentLoaded', () =>
            wait(1000).then(() => {
                setVisible('.card', true);
                setVisible('#loading', false);
            }));
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('deskripsi');
            const charCount = document.getElementById('charCount');
            const maxLength = textarea.getAttribute('maxlength');

            function updateCharCount() {
                const currentLength = textarea.value.length;
                charCount.textContent = `${currentLength}/${maxLength}`;
                if (currentLength > maxLength) {
                    charCount.classList.add('text-danger');
                } else {
                    charCount.classList.remove('text-danger');
                }
            }

            textarea.addEventListener('input', updateCharCount);

            // Set initial count
            updateCharCount();
        });
    </script>
@endpush
