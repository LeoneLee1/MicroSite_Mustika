@extends('layout.app')

@section('title', 'Data Register Account - PT Mustika Jaya Lestari')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm" id="regis-table">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        $(document).ready(function() {
            $('#regis-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 50, 100, -1],
                    [10, 50, 100, "All"]
                ],
                ajax: '{{ route('user.regis.json') }}',
                columns: [{
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        className: 'text-center'
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                        className: 'text-center'
                    },
                    {
                        data: 'unit',
                        name: 'unit',
                        className: 'text-center'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp',
                        className: 'text-center'
                    },
                    {
                        name: 'action',
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<a href="/register/data/see/' + data +
                                '" class="btn btn-success btn-sm">Approve</a>&nbsp;&nbsp;' +
                                '<a href="/register/data/reject/' + data +
                                '" class="btn btn-danger btn-sm" onclick="return Reject()">Reject</a>';
                        },
                        className: 'text-center'
                    }
                ],
            });
        });
    </script>
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
