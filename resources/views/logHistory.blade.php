@extends('layout.app')

@section('title', 'Log History - Pendarrasa')

@push('after-style')
    <style>
        .log-card {
            border-left: 4px solid #007bff;
            margin-bottom: 20px;
        }

        .success {
            color: #28a745;
        }

        .error {
            color: #dc3545;
        }

        .time {
            font-size: 0.9rem;
            color: black;
        }
    </style>

    {{-- sidebar style --}}
    <style>
        /* Sidebar Style */
        .sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            /* Tersembunyi di luar layar */
            width: 300px;
            /* Ukuran sidebar bisa disesuaikan */
            height: 100%;
            background-color: #f8f9fa;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease-in-out;
            z-index: 3040;
            /* Di bawah navbar */
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .sidebar.active {
            right: 0;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="col-2">
                {{-- <a href="#" id="filterButton">
                    <i class="fa fa-filter"></i>&nbsp;Filter
                </a> --}}
                <!-- Sidebar -->
                <div id="sidebar" class="sidebar">
                    <div class="sidebar-header">
                        <button id="closeSidebar" class="btn btn-danger btn-sm">&times;</button>
                        <h5>Filter Logs</h5>
                    </div>
                    <div class="sidebar-content">
                        <form action="{{ route('log') }}" method="GET" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Tanggal Awal</label>
                                <input type="date" name="tanggal_awal" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary" name="action" value="view_data">Submit</button>
                        </form>
                    </div>
                </div>
                {{-- ------- --}}
            </div>
            <h3 class="mb-2 text-center card-title" style="color: black;">📜 Log History</h3>
            <div class="mb-4">
                @php
                    $daftar_bulan = [
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober',
                        'November' => 'November',
                        'December' => 'Desember',
                    ];
                @endphp
                @if ($logsByTanggal->isNotEmpty())
                    @foreach ($logsByTanggal as $tanggal => $logs)
                        @php
                            $currentDate = Carbon\Carbon::parse($tanggal);
                            $bulan = $daftar_bulan[$currentDate->format('F')];
                            $tahun = $currentDate->format('Y');
                            $formattedTanggal = "{$currentDate->format('j')} {$bulan} {$tahun}";
                        @endphp
                        <h5 class="text-primary">🗓️ {{ $formattedTanggal }}</h5>
                        <div class="card log-card p-3 mb-4">
                            <ul class="list-group list-group-flush">
                                @foreach ($logs as $item)
                                    <li class="list-group-item mb-2">
                                        <span class="fw-bold text-success me-2"><i
                                                class="fa fa-user me-2"></i>{{ $item->nama }}</span> <span
                                            class="me-2">-</span>
                                        <span class="text-warning">{{ $item->activity }}</span>
                                        <span class="time float-end"><i class="fas fa-clock" style="color: red;"></i>
                                            {{ Carbon\Carbon::parse($item->created_at)->format('H:i') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @else
                    <div class="text-center mt-4">
                        <h3 class="text-primary">❌ Data Log History anda masih kosong ❌</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        document.getElementById('filterButton').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('sidebar').classList.add('active');
        });
        document.getElementById('closeSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
        });
    </script>
@endpush
