<!-- Modal -->
@foreach ($komen as $row)
    <div class="modal fade" id="report{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button class="btn btn-danger" style="width: 100%; margin-bottom: 10px;">Laporkan</button>
                    <button class="btn btn-secondary" style="width: 100%;" data-bs-dismiss="modal">Batalkan</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
