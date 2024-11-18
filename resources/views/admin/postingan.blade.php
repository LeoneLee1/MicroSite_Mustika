@extends('layout.app')

@section('title', 'ADMIN DASHBOARD')

@php
    $no = 1;
@endphp

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NIK</th>
                            <th>NAMA</th>
                            <th>MEDIA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($post as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->media }}</td>
                                <td>
                                    <a href="{{ route('post.lihat', $item->id) }}" class="btn btn-sm btn-warning">Lihat</a>
                                    <a href="{{ route('admin.postEdit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="#" onclick="return delete()" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        function delete() {
            if (confirm('Delete?')) {
                return true
            } else {
                return false
            }
        }
    </script>
@endpush
