@extends('layout.app')

@section('title', 'Edit - PT Mustika Jaya Lestari')

@section('content')
    <div class="row justify-content-center">
        <div class="col col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('profile') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i>&nbsp;Batal</a>
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
                            <input type="text" name="media" class="form-control" value="{{ $post->media }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="8" maxlength="1000" required id="deskripsi">{{ $post->deskripsi }}</textarea>
                            <small id="charCount" class="form-text text-muted">0/1000</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- @if ($poll === null || collect($poll)->isEmpty())
    @endif
    @foreach ($poll as $p)
        <div class="row justify-content-center">
            <div class="col col-12 col-md-6">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="text-center">
                            <h4 style="color: black; font-weight: bold;">Soal</h4>
                        </div>
                        <form action="{{ route('post.update.soal', $p->id_post) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Soal</label>
                                <input type="text" name="soal" class="form-control" value="{{ $p->soal }}">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}
    {{-- @if ($jawaban === null || collect($jawaban)->isEmpty())
    @endif
    <div class="row justify-content-center">
        <div class="col col-12 col-md-6">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="text-center">
                        <h4 style="color: black; font-weight: bold;">Jawaban</h4>
                    </div>
                    <form action="{{ route('post.update.jawaban', $post->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Jawaban</label>
                            @foreach ($jawaban as $j)
                                <input type="text" name="jawaban" class="form-control mb-2" value="{{ $j->jawaban }}">
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('after-script')
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
