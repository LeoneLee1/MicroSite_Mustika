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
                <table class="table text-center table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nik</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->nik }}</td>
                                <td>{{ $row->unit }}</td>
                                <td>
                                    <a href="{{ route('user.edit', $row->id) }}" class="btn btn-sm btn-info"><i
                                            class="fa fa-pencil"></i></a>
                                    <a href="{{ route('user.delete', $row->id) }}" class="btn btn-sm btn-danger"
                                        onclick="return confirmDelete()"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $data->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection

@push('after-script')
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
