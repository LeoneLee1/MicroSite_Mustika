@extends('layout.app')

@section('title', 'Data Register Account - PT Mustika Jaya Lestari')

@section('content')
    @if ($data === null)
        <div class="text-center" style="align-items: center; justify-content: center; margin-top: 220px;">
            <h4 style="color: black; font-weight: bold;">No Data!</h4>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                {{-- <form action="{{ route('user.regis.cari') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-dark"><i class="fa fa-search"></i></button>&nbsp;&nbsp;
                        <input type="text" id="search-input" class="form-control" placeholder="Cari pengguna..."
                            name="cari" value="{{ old('cari') }}">
                    </div>
                </form> --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm" id="users-table">
                        <thead>
                            <tr>
                                <th scope="col" style="color: black; font-weight: bold;">No</th>
                                <th scope="col" style="color: black; font-weight: bold;">Nama</th>
                                <th scope="col" style="color: black; font-weight: bold;">Username / Nik</th>
                                <th scope="col" style="color: black; font-weight: bold;">Nomor Hp</th>
                                <th scope="col" style="color: black; font-weight: bold;">Unit</th>
                                <th scope="col" style="color: black; font-weight: bold;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                @if ($row->sofdel == 0)
                                    <tr>
                                        <td style="color: black;">{{ $loop->index + 1 }}</td>
                                        <td style="color: black;">{{ $row->nama }}</td>
                                        <td style="color: black;">{{ $row->nik }}</td>
                                        <td style="color: black;">{{ $row->no_hp }}</td>
                                        <td style="color: black;">{{ $row->unit }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $row->id }}">Approve</a>
                                            @include('modal.approve')
                                            <a href="{{ route('user.reject', $row->id) }}" class="btn btn-sm btn-danger"
                                                onclick="return Reject()">Reject</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $data->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    @endif
@endsection

@push('after-script')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('search-input');
            const userTable = document.getElementById('users-table');
            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();
                const rows = userTable.getElementsByTagName('tr');
                for (let i = 1; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let match = false;
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                    rows[i].style.display = match ? '' : 'none';
                }
            });
        });
    </script> --}}
    <script>
        function Reject() {
            console.log("Reject");
            if (confirm("Are u Sure Want To Reject?")) {
                console.log("Success Reject");
                return true;
            } else {
                console.log("Cancel Reject");
                return false;
            }
        }
    </script>
@endpush
