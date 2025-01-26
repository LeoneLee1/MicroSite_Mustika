@extends('layout.app')

@section('title', 'ADMIN DASHBOARD - PENDARRASA')

@php
    $no = 1;
@endphp

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NIK</th>
                                <th>NAMA</th>
                                <th>JUDUL</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($post as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td title="{{ $item->judul }}">{!! Str::limit($item->judul, 15, '....') !!}</td>
                                    <td>
                                        <a href="{{ route('post.lihat', $item->id) }}" class="btn btn-sm btn-warning"><i
                                                class="fa fa-eye"></i></a>
                                        <a href="{{ route('post.edit', $item->id) }}" class="btn btn-sm btn-primary"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="{{ route('post.delete', $item->id) }}" onclick="return Delete()"
                                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $post->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        function Delete() {
            if (confirm('Delete?')) {
                return true
            } else {
                return false
            }
        }
    </script>
@endpush
