<!-- Modal -->
@foreach ($data as $row)
    <div class="modal fade" id="exampleModal{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.approve', $row->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="no_hp" value="{{ $row->no_hp }}">
                        <div class="mb-3">
                            <div class="form-group">
                                <label style="color: black;">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $row->nama }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label style="color: black;">Username / Nik</label>
                                <input type="text" name="nik" class="form-control" value="{{ $row->nik }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label style="color: black;">Unit</label>
                                <input type="text" name="unit" class="form-control" value="{{ $row->unit }}"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Role" class="form-label">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                                <option value="Pengamat">Pengamat</option>
                                <option value="Anonymous">Anonymous</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label style="color: black;">Password</label>
                                <input type="text" name="password" class="form-control"
                                    placeholder="Password"required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary"
                            onclick="return Approve()">Approve</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function Approve() {
        if (confirm("Aprrove?")) {
            console.log("terkirim");
            return true;
        } else {
            console.log("Batal");
            return false;
        }
    }
</script>
