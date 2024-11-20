<!-- Modal -->
<div class="modal fade" id="akunKomen{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="color: black; font-weight: bold;">Nama Lengkap:</p>
                <p style="color: #003366;">{{ $row->nama }}</p>
                <p style="color: black; font-weight: bold;">Unit:</p>
                <p style="color: #003366;">{{ $row->unit }}</p>
                <p style="color: black; font-weight: bold;">Ap:</p>
                <p style="color: #003366;">{{ $row->ap }}</p>
                <p style="color: black; font-weight: bold;">Gender:</p>
                @if ($row->gender == true)
                    <p style="color: #003366;">{{ $row->gender }}</p>
                @else
                    <p>-</p>
                @endif
            </div>
        </div>
    </div>
</div>
