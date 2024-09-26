@extends('layout.app')

@section('title', 'Post - PT Mustika Jaya Lestari')

@push('after-style')
    <style>
        input[type="radio"]:disabled {
            opacity: 1 !important;
            cursor: not-allowed;
        }

        input[type="radio"]:disabled+label {
            color: #000000;
        }
    </style>
@endpush

@section('navbar-item')
    <a href="{{ route('/') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
@endsection

@section('content')
    @foreach ($data as $item)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-left d-none d-sm-block">
                            <strong style="color: black;">
                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                    alt class="w-px-50 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                            </strong>&nbsp;&nbsp;•
                            {{ \Carbon\Carbon::parse($item->time_post)->format('d M Y') }}
                        </div>
                        <div class="text-left d-block d-sm-none">
                            <strong style="color: black;">
                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                    alt class="w-px-50 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                            </strong>
                        </div>
                    </div>
                    <div class="text-center">
                        @if (strpos($item->media, '.mp4') !== false ||
                                strpos($item->media, '.webm') !== false ||
                                strpos($item->media, '.ogg') !== false)
                            <video controls class="img-fluid">
                                <source src="{{ $item->media }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @elseif (strpos($item->media, 'youtube.com') !== false || strpos($item->media, 'youtu.be') !== false)
                            @php
                                preg_match(
                                    '/(youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/',
                                    $item->media,
                                    $matches,
                                );
                                $youtubeId = $matches[2];
                            @endphp
                            <div class="d-none d-sm-block">
                                <iframe style="max-width: 1000px; min-width: 1000px; height: 350px;"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen class="img-fluid lazyload"></iframe>
                            </div>
                            <div class="d-block d-sm-none">
                                <iframe style="max-width: 260px; min-width: 260px; height: 200px;"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen class="img-fluid lazyload"></iframe>
                            </div>
                        @elseif (strpos($item->media, '.jpg') !== false ||
                                strpos($item->media, '.jpeg') !== false ||
                                strpos($item->media, '.png') !== false ||
                                strpos($item->media, 'data:image') !== false ||
                                strpos($item->media, '.gif') !== false)
                            <img src="{{ $item->media }}" alt="media gambar" class="img-fluid lazyload"
                                style="min-width: 300px; height: 300px;">
                        @else
                            @if (filter_var($item->media, FILTER_VALIDATE_URL))
                                <div>
                                    <a href="{{ $item->media }}" target="_blank" class="btn btn-primary btn-sm">Read
                                        Article
                                        or
                                        View
                                        Material</a>
                                </div>
                            @else
                                <p>Unsupported media type or URL.</p>
                            @endif
                        @endif
                    </div>
                    <div class="text-left mt-4 mb-2">
                        <h5 style="color: black; font-weight: bold;">{{ $item->judul }}</h5>
                    </div>
                    <div class="d-flex justify-content-start mt-2">
                        @if ($item->liked)
                            <button class="btn btn-outline-danger me-3 d-flex align-items-center"
                                style="border-radius: 50px;" onclick="return like({{ $item->id }})">
                                <i class="fas fa-heart me-2"></i>
                                <span>Like</span>
                                <span class="badge bg-danger ms-2">{{ $item->like }}</span>
                            </button>
                        @else
                            <button class="btn btn-outline-secondary me-3 d-flex align-items-center"
                                style="border-radius: 50px;" onclick="return like({{ $item->id }})">
                                <i class="fas fa-heart me-2"></i>
                                <span>Like</span>
                                <span class="badge bg-secondary ms-2">{{ $item->like }}</span>
                            </button>
                        @endif
                        <a href="{{ route('comment', $item->id) }}"
                            class="btn btn-outline-primary d-flex align-items-center" style="border-radius: 50px;">
                            <i class="fas fa-comment me-2"></i>
                            <span>Comment</span>
                            {{-- <span class="badge bg-primary ms-2">{{ $item->comments_count ?? 0 }}</span> --}}
                        </a>
                    </div>
                    <div class="text-left mt-4">
                        <span style="color: black;">
                            <span class="short-text">
                                {!! nl2br(e(Str::limit($item->deskripsi, 500))) !!}
                            </span>
                            <span class="full-text" style="display: none;">
                                {!! nl2br(e($item->deskripsi)) !!}
                            </span>
                            <a href="javascript:void(0);" class="view-more" style="display: none; color: red;">View
                                More</a>
                        </span>
                    </div>
                    <div class="mt-1">
                        <div class="text-left">
                            <a href="{{ route('comment', $item->id) }}">View All Comments</a>
                        </div>
                    </div>
                    <div class="d-flex row justify-content-start align-items-center mt-2">
                        @php $count = 0; @endphp
                        @foreach ($komen as $k)
                            @if ($k->id_post === $item->id)
                                @php $count++; @endphp
                                @if ($count <= 1)
                                    <div style="color: black;" class="mb-2">
                                        <span style="font-weight: bold;">
                                            {{ $k->nik }}
                                        </span>{{ $k->comment }}
                                    </div>
                                @else
                                @break
                            @endif
                        @endif
                    @endforeach
                    @if (!Auth::user()->role === 'Pengamat')
                        <div class="mt-2">
                            <div class="d-flex justify-content-start col-sm-5">
                                <form method="POST" action="{{ route('comment.insert') }}"
                                    enctype="multipart/form-data" class="d-flex align-items-left w-100 comment-form">
                                    @csrf
                                    <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                                    <input type="hidden" name="id_post" value="{{ $item->id }}">
                                    <div class="input-group me-2" style="flex: 1;">
                                        <span class="input-group-text bg-white border-0 p-0" id="basic-addon1">
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt="User Avatar" class="w-px-40 h-auto rounded-circle lazyload"
                                                style="object-fit: cover;" />
                                        </span>
                                        <input type="text" name="comment" id="komentar" class="form-control"
                                            style="border-radius: 50px;" placeholder="Add Comments...." required>
                                    </div>
                                    <button hidden type="submit" class="btn btn-primary btn-sm me-2"
                                        style="border-radius: 50px;">Send</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    <div class="mt-3">
                        <small>{{ \Carbon\Carbon::parse($item->time_post)->format('d M Y') }}</small>
                    </div>
                    <div class="mt-4">
                        @foreach ($poll as $p)
                            @if ($p->id_post == $item->id)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center mb-4">
                                            <h4 style="font-weight: bold; color: black;">{{ $p->soal }}</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                @foreach ($jawaban as $a)
                                                    @if ($a->id_post == $item->id && $a->poll_id == $p->id)
                                                        <div
                                                            class="mb-2 d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="radio" id="option{{ $a->id }}"
                                                                    name="poll{{ $p->id }}"
                                                                    class="form-check-input"
                                                                    @if (Auth::user()->role === 'Pengamat') disabled @endif
                                                                    @if ($a->voted) checked @endif
                                                                    onclick="return vote({{ $a->id }})">
                                                                <label class="form-check-label"
                                                                    for="option{{ $a->id }}">{{ $a->jawaban }}</label>
                                                            </div>
                                                            <span class="badge bg-primary">{{ $a->value }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="col-md-6">
                                                <div class="chart-container">
                                                    <canvas id="myChart{{ $p->id }}"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-4">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#viewVote{{ $p->id }}"
                                                class="btn btn-success">View votes</a>
                                        </div>
                                        @include('modal.viewVote')
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endforeach
@endsection

@push('after-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    const polling = @json($polling);

    const groupedPolling = polling.reduce((acc, item) => {
        if (!acc[item.poll_id]) {
            acc[item.poll_id] = [];
        }
        acc[item.poll_id].push(item);
        return acc;
    }, {});

    function truncateLabel(label, maxLength = 15) {
        return label.length > maxLength ? label.slice(0, maxLength) + '...' : label;
    }

    Chart.register(ChartDataLabels);

    Object.entries(groupedPolling).forEach(([pollId, items]) => {
        const xValues = items.map(item => item.jawaban);
        const yValues = items.map(item => item.value);
        const truncatedLabels = xValues.map(label => truncateLabel(label));
        const barColors = [
            "#3498db", "#2ecc71", "#e74c3c", "#f39c12", "#9b59b6",
            "#1abc9c", "#d35400", "#34495e", "#16a085", "#2980b9"
        ];

        new Chart("myChart" + pollId, {
            type: "pie",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors.slice(0, xValues.length),
                    data: yValues
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const dataset = context.dataset;
                                const total = dataset.data.reduce((acc, data) => acc + data, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 10
                        },
                        formatter: (value, ctx) => {
                            const dataset = ctx.chart.data.datasets[0];
                            const total = dataset.data.reduce((acc, data) => acc + data, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return percentage + '%';
                        }
                    }
                }
            }
        });
    });
</script>
<script>
    function vote(answerId) {
        console.log("Id Answer:", answerId);
        var scrollPosition = $(window).scrollTop();
        $.ajax({
            url: '/vote/' + answerId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    console.log("Voted");
                    window.location.reload();
                } else {
                    console.error("Failed Vote");
                }
            },
            error: function(xhr) {
                console.error("Terjadi Kesalahan:", xhr.responseText);
            }
        });
        $(window).on('load', function() {
            $(window).scrollTop(scrollPosition);
        });
        return false;
    }
</script>
<script>
    $(document).ready(function() {
        $('.text-left').each(function() {
            var fullText = $(this).find('.full-text');
            var shortText = $(this).find('.short-text');
            var viewMoreLink = $(this).find('.view-more');

            if (fullText.text().length > 500) {
                viewMoreLink.show();
            } else {
                shortText.text(fullText.text());
            }
        });

        $('.view-more').click(function() {
            var shortText = $(this).siblings('.short-text');
            var fullText = $(this).siblings('.full-text');

            if (shortText.is(':visible')) {
                shortText.hide();
                fullText.show();
                $(this).text('View Less');
            } else {
                shortText.show();
                fullText.hide();
                $(this).text('View More');
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.comment-form').each(function() {
            var form = $(this);

            form.on('submit', function(e) {
                e.preventDefault();

                var data = form.serialize();
                var scrollPosition = $(window).scrollTop();
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: data,
                    processData: false,
                    success: function(response) {
                        console.log('Form submitted successfully:', response);
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error submitting form:', error);
                    }
                });
                $(window).on('load', function() {
                    $(window).scrollTop(scrollPosition);
                });
            });
        });
    });
</script>
@endpush
