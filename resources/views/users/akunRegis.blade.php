@extends('layout.app')

@section('title', 'Data Register Account - PT Mustika Jaya Lestari')

@section('content')
    @if ($data->isEmpty())
        <div class="text-center" style="align-items: center; justify-content: center; margin-top: 220px;">
            <h4 style="color: black; font-weight: bold;">No Data!</h4>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $data->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @endif
@endsection

@push('after-script')
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
