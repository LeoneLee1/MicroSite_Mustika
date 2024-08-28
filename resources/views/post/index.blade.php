@extends('layout.app')

@section('title', 'Post - PT Mustika Jaya Lestari')

@section('content')
    <div class="row justify-content-center">
        <div class="col col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" placeholder="Judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Media</label>
                            <input type="text" name="media" placeholder="Link URL" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="8"></textarea>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" name="polling" id="pollingCheck" value="">
                            <label class="form-check-label" for="pollingCheck">
                                Polling?
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
