@extends('layout.app')

@section('title', 'Polling - PT Mustika Jaya Lestari')

@section('content')
    <div class="row justify-content-center">
        <div class="col col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('polling.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id_post" value="{{ $post_id }}">
                        <div class="mb-3">
                            <label class="form-label">Soal</label>
                            <input type="text" name="soal" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jawaban</label>
                            <div id="dynamic-field-1" class="form-group dynamic-field">
                                <input type="text" name="jawaban[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3 text-end">
                            <button type="button" id="add-button" class="btn btn-secondary btn-sm">Tambah Jawaban</button>
                            <button type="button" id="remove-button" class="btn btn-danger btn-sm">Hapus Jawaban</button>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection

@push('after-script')
    <script>
        let fieldCount = 1;

        // Tambah field jawaban baru
        $('#add-button').click(function() {
            fieldCount++;
            let newField = `<div id="dynamic-field-${fieldCount}" class="form-group dynamic-field">
                            <input type="text" name="jawaban[]" class="form-control" required>
                        </div>`;
            $('.dynamic-field:last').after(newField);
        });

        // Hapus field jawaban terakhir
        $('#remove-button').click(function() {
            if (fieldCount > 1) {
                $('#dynamic-field-' + fieldCount).remove();
                fieldCount--;
            }
        });
    </script>
@endpush
