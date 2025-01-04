<!-- Modal -->
<div class="modal fade" id="akunKomenBalas{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="color: black; font-weight: bold;">Nama Lengkap:</p>
                <p style="color: #003366;">{{ $item->nama }}</p>
                @if (Auth::user()->nik === 'daniel.it')
                    <p style="color: black; font-weight: bold;">NIK:</p>
                    <p style="color: #003366;">{{ $item->nik }}</p>
                @endif
                <p style="color: black; font-weight: bold;">Unit:</p>
                <p style="color: #003366;">{{ $item->unit }}</p>
                <p style="color: black; font-weight: bold;">Gender:</p>
                @if ($item->gender == true)
                    <p style="color: #003366;">{{ $item->gender }}</p>
                @else
                    <p>-</p>
                @endif
            </div>
        </div>
    </div>
</div>
