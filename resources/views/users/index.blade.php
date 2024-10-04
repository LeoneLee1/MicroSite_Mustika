@extends('layout.app')

@section('title', 'User - PT Mustika Jaya Lestari')

@section('content')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <h1>User Management</h1>
            </div>
            <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Create</a>
            <div class="table-responsive mt-4">
                <table class="table text-center table-bordered table-striped" id="users-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nik</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection

@push('after-script')
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                lengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                ajax: '{{ route('user.json') }}',
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
                        data: 'gender',
                        name: 'gender',
                        className: 'text-center'
                    },
                    {
                        data: 'role',
                        name: 'role',
                        className: 'text-center'
                    },
                    {
                        name: 'action',
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<a href="user/edit/' + data +
                                '" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a>&nbsp;&nbsp;' +
                                '<a href="user/delete/' + data +
                                '" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>';
                        },
                        className: 'text-center'
                    }
                ],
            });
        });
    </script>
    <script>
        function confirmDelete() {
            if (confirm("Apakah kamu yakin ingin menghapus?")) {
                console.log("Delete confirmed!");
                return true;
            } else {
                console.log("Delete canceled!");
                return false;
            }
        }
    </script>
@endpush
