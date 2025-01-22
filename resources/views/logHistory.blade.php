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
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
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
