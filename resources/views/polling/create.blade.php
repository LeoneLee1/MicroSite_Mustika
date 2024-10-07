@extends('layout.app')

@section('title', 'Polling - Pendarasa')

@section('content')
    <div class="row justify-content-center">
        <div class="col col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('polling.insert') }}" method="POST" enctype="multipart/form-data" id="pollingForm">
                        @csrf
                        <!-- Menggunakan satu id_post untuk semua soal -->
                        <input type="hidden" name="id_post" value="{{ $post_id }}">
                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">

                        <!-- Wrapper untuk soal-soal -->
                        <div id="soal-wrapper">
                            <!-- Soal Pertama -->
                            <div id="dynamic-soal-1" class="soal-group mb-4">
                                <h5>Soal 1</h5>
                                <div class="mb-3">
                                    <label class="form-label">Soal</label>
                                    <input type="text" name="soal[1]" class="form-control"
                                        placeholder="Soal / Pertanyaan" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jawaban</label>
                                    <div id="dynamic-field-1-1" class="form-group dynamic-field mb-3">
                                        <input type="text" name="jawaban[1][]" class="form-control" placeholder="Jawaban"
                                            required>
                                    </div>
                                </div>
                                <div class="mb-3 text-end">
                                    <button type="button" class="btn btn-secondary btn-sm add-answer"
                                        data-soal-id="1">Tambah Jawaban</button>
                                    <button type="button" class="btn btn-danger btn-sm remove-answer"
                                        data-soal-id="1">Hapus Jawaban</button>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol untuk menambah dan menghapus soal -->
                        <div class="mb-3 text-end">
                            <button type="button" id="add-soal-button" class="btn btn-success btn-sm">Tambah Soal</button>
                            <button type="button" id="remove-soal-button" class="btn btn-danger btn-sm">Hapus Soal</button>
                        </div>

                        <!-- Tombol simpan -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="/" class="btn btn-warning">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection

@push('after-script')
    <script>
        let soalCount = 1;
        let jawabanCount = {
            1: 1
        }; // Track jumlah jawaban untuk tiap soal

        // Tambah soal baru
        $('#add-soal-button').click(function() {
            soalCount++;
            jawabanCount[soalCount] = 1;
            let newSoal = `<div id="dynamic-soal-${soalCount}" class="soal-group mb-4">
                            <h5>Soal ${soalCount}</h5>
                            <div class="mb-3">
                                <label class="form-label">Soal</label>
                                <input type="text" name="soal[${soalCount}]" class="form-control" placeholder="Soal / Pertanyaan" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jawaban</label>
                                <div id="dynamic-field-${soalCount}-1" class="form-group dynamic-field mb-3">
                                    <input type="text" name="jawaban[${soalCount}][]" class="form-control" placeholder="Jawaban" required>
                                </div>
                            </div>
                            <div class="mb-3 text-end">
                                <button type="button" class="btn btn-secondary btn-sm add-answer" data-soal-id="${soalCount}">Tambah Jawaban</button>
                                <button type="button" class="btn btn-danger btn-sm remove-answer" data-soal-id="${soalCount}">Hapus Jawaban</button>
                            </div>
                        </div>`;
            $('#soal-wrapper').append(newSoal);
        });

        // Hapus soal terakhir
        $('#remove-soal-button').click(function() {
            if (soalCount > 1) {
                $('#dynamic-soal-' + soalCount).remove();
                delete jawabanCount[soalCount];
                soalCount--;
            }
        });

        // Tambah field jawaban baru untuk soal tertentu
        $(document).on('click', '.add-answer', function() {
            let soalId = $(this).data('soal-id');
            jawabanCount[soalId]++;
            let newField = `<div id="dynamic-field-${soalId}-${jawabanCount[soalId]}" class="form-group dynamic-field mb-3">
                            <input type="text" name="jawaban[${soalId}][]" class="form-control" placeholder="Jawaban" required>
                        </div>`;
            $('#dynamic-field-' + soalId + '-' + (jawabanCount[soalId] - 1)).after(newField);
        });

        // Hapus field jawaban terakhir untuk soal tertentu
        $(document).on('click', '.remove-answer', function() {
            let soalId = $(this).data('soal-id');
            if (jawabanCount[soalId] > 1) {
                $('#dynamic-field-' + soalId + '-' + jawabanCount[soalId]).remove();
                jawabanCount[soalId]--;
            }
        });
    </script>
@endpush
