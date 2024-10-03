@extends('layout.app')

@section('title', 'Pendarasa - PT Mustika Jaya Lestari')

@push('after-style')
    <style>
        input[type="radio"]:disabled {
            opacity: 1 !important;
            cursor: not-allowed;
        }

        input[type="radio"]:disabled+label {
            color: #000000;
        }

        /* Container for spinner */
        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 20px;
        }

        /* Spinner styles */
        .spinner {
            width: 40px;
            height: 40px;
            border: 5px solid rgba(0, 0, 0, 0.2);
            border-top-color: #3498db;
            /* Custom color */
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Animation for spinner rotation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Smooth fade-in effect for new content */
        .infinite-scroll>* {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
@endpush

@section('navbar-item')
    <div class="d-none d-sm-block">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchPost"><i
                class="fa fa-search"></i>&nbsp;&nbsp;Search Post</a>
    </div>
    <div class="d-block d-sm-none">
        <a href="#" data-bs-toggle="modal" data-bs-target="#searchPost" class="btn btn-primary btn-sm"><i
                class="fa fa-search"></i>&nbsp;&nbsp;Search</a>
    </div>
@endsection

@section('content')
    @include('modal.cariPost')
    @foreach ($post as $item)
        <div class="infinite-scroll" id="infinite-scroll">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            @if ($item->foto == '' || null)
                                <div class="text-left d-none d-sm-block">
                                    <strong style="color: black;">
                                        <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                            alt
                                            class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;{{ $item->nama }}
                                    </strong>&nbsp;&nbsp;•
                                    {{ \Carbon\Carbon::parse($item->time_post)->format('d M Y') }}
                                </div>
                                <div class="text-left d-block d-sm-none">
                                    <strong style="color: black;">
                                        <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                            alt
                                            class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;{{ $item->nama }}
                                    </strong>
                                </div>
                            @else
                                <div class="text-left d-none d-sm-block">
                                    <strong style="color: black;">
                                        <img src="{{ asset('img/foto/' . $item->foto) }}" alt
                                            class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                                    </strong>&nbsp;&nbsp;•
                                    {{ \Carbon\Carbon::parse($item->time_post)->format('d M Y') }}
                                </div>
                                <div class="text-left d-block d-sm-none">
                                    <strong style="color: black;">
                                        <img src="{{ asset('img/foto/' . $item->foto) }}" alt
                                            class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                                    </strong>
                                </div>
                            @endif
                            <div class="dropdown">
                                <button class="btn btn-link text-dark" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#"
                                            onclick="return save({{ $item->id }})"><i class="fas fa-bookmark menu-icon"
                                                style="color: rgb(105, 105, 247)"></i>&nbsp;Simpan</a></li>
                                    </li>
                                </ul>
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
                        @if (Auth::user()->role == 'Pengamat')
                        @else
                            <div class="mt-2">
                                <div class="d-flex justify-content-start col-sm-5">
                                    <form method="POST" action="{{ route('comment.insert') }}"
                                        enctype="multipart/form-data"
                                        class="d-flex align-items-left w-100 comment-form">
                                        @csrf
                                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                                        <input type="hidden" name="id_post" value="{{ $item->id }}">
                                        <div class="input-group me-2" style="flex: 1;">
                                            <span class="input-group-text bg-white border-0 p-0" id="basic-addon1">
                                                @if (Auth::user()->foto == '' || null)
                                                    <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                        alt="User Avatar"
                                                        class="w-px-40 h-auto rounded-circle lazyload"
                                                        style="object-fit: cover;" />
                                                @else
                                                    <img src="{{ asset('img/foto/' . Auth::user()->foto) }}"
                                                        alt="User Avatar"
                                                        class="w-px-40 h-auto rounded-circle lazyload"
                                                        style="object-fit: cover;" />
                                                @endif
                                            </span>
                                            <input type="text" name="comment" id="komentar" class="form-control"
                                                style="border-radius: 50px; margin-left: 10px;"
                                                placeholder="Add Comments...." required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm me-2"
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
                                    <div class="text-center mb-4">
                                        <h4 style="font-weight: bold; color: black;">{{ $p->soal }}</h4>
                                    </div>
                                    <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                                        <div class="row">
                                            <div class="col-md-8">
                                                @foreach ($jawaban as $a)
                                                    @if ($a->id_post == $item->id && $a->poll_id == $p->id)
                                                        <div
                                                            class="mb-2 d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                @if (Auth::user()->role === 'Pengamat')
                                                                    <input type="radio"
                                                                        id="option{{ $a->id }}"
                                                                        name="poll{{ $p->id }}"
                                                                        class="form-check-input" disabled
                                                                        @if ($a->voted) checked @endif
                                                                        onclick="return vote({{ $a->id }})">
                                                                @else
                                                                    <input type="radio"
                                                                        id="option{{ $a->id }}"
                                                                        name="poll{{ $p->id }}"
                                                                        class="form-check-input"
                                                                        @if ($a->voted) checked @endif
                                                                        onclick="return vote({{ $a->id }})">
                                                                @endif
                                                                <label class="form-check-label"
                                                                    for="option{{ $a->id }}">{{ $a->jawaban }}</label>
                                                            </div>
                                                            <span class="badge bg-primary">{{ $a->value }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @foreach ($poll as $p)
                                                @if ($p->id_post == $item->id)
                                                    <div class="col-md-4">
                                                        <div style="position: relative; height:250px; width:100%;">
                                                            <canvas id="myChart{{ $p->id }}"></canvas>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @foreach ($poll as $p)
                                        @if ($p->id_post == $item->id)
                                            <div class="text-center mb-4">
                                                {{-- <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#viewVote{{ $p->id }}"
                                                    class="btn btn-success">View
                                                    votes</a>
                                                    @include('modal.viewVote') --}}
                                                <a href="{{ route('viewVote', $p->id) }}" class="btn btn-success">View
                                                    votes</a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                        {{ $post->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
@endforeach
@endsection

@push('after-script')
<script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
<script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: `
                <div class="loading-container">
                    <div class="spinner"></div>
                    <p style="text-align: center; margin-top: 10px;">Loading more content...</p>
                </div>`,
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
                $('.infinite-scroll').children().css('opacity', 0).animate({
                    opacity: 1
                }, 500);
                initializeCharts(); // Inisialisasi ulang chart setelah konten baru dimuat
            }
        });
    });

    function initializeCharts() {
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

            const canvasId = "myChart" + pollId;
            const canvasElement = document.getElementById(canvasId);

            if (canvasElement) {
                new Chart(canvasElement, {
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
                                        const total = dataset.data.reduce((acc, data) => acc + data,
                                            0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 11
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
            } else {
                console.warn(`Canvas element with ID ${canvasId} not found.`);
            }
        });
    }

    // Inisialisasi chart saat dokumen pertama kali dimuat
    $(document).ready(function() {
        initializeCharts();
    });
</script>

<script>
    function save(Id) {
        console.log("Id Post:", Id);
        var scrollPosition = $(window).scrollTop();
        $.ajax({
            url: '/save/' + Id,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    console.log("Saved");
                    alert("Berhasil menyimpan postingan.");
                    return true;
                    window.location.reload();
                } else {
                    console.error("Failed Saved");
                    alert("Postingan ini sudah tersimpan.");
                    return false;
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
    function like(postId) {
        console.log("Id Post:", postId);
        var scrollPosition = $(window).scrollTop();
        $.ajax({
            url: '/like/' + postId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    console.log("Liked");
                    window.location.reload();
                } else {
                    console.error("Failed Like");
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
{{-- <script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: `
                <div class="loading-container">
                    <div class="spinner"></div>
                    <p style="text-align: center; margin-top: 10px;">Loading more content...</p>
                </div>`,
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
                $('.infinite-scroll').children().css('opacity', 0).animate({
                    opacity: 1
                }, 500);
            }
        });
    });
</script> --}}
{{-- <script>
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
                            size: 11
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
</script> --}}
@endpush
