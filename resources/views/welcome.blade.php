@extends('layout.app')

@section('title', 'Pendarasa')

@push('after-style')
    <style>
        input[type="radio"]:disabled {
            opacity: 1 !important;
            cursor: not-allowed;
        }

        input[type="radio"]:disabled+label {
            color: #000000;
        }

        .refresh-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            width: 40px;
            height: 40px;
            background-color: #6777ef;
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 15px;
        }
    </style>
@endpush

@include('modal.cariPost')
@include('modal.menyukai')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($post as $item)
                @include('modal.akun')
                <div class="card mb-3" style="width: 55rem;">
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                @if ($item->foto == '' || null)
                                    <div class="text-left d-none d-sm-block" data-bs-toggle="modal"
                                        data-bs-target="#akun{{ $item->id }}" style="cursor: pointer;">
                                        <strong style="color: black;">
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt
                                                class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;{{ $item->nama }}
                                        </strong>&nbsp;&nbsp;•
                                        {{ \Carbon\Carbon::parse($item->time_post)->diffForHumans() }}
                                    </div>
                                    <div class="text-left d-block d-sm-none" data-bs-toggle="modal"
                                        data-bs-target="#akun{{ $item->id }}" style="cursor: pointer;">
                                        <strong style="color: black;">
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt
                                                class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;{{ $item->nama }}
                                        </strong>
                                    </div>
                                @else
                                    <div class="text-left d-none d-sm-block" data-bs-toggle="modal"
                                        data-bs-target="#akun{{ $item->id }}" style="cursor: pointer;">
                                        <strong style="color: black;">
                                            <img src="{{ asset('img/foto/' . $item->foto) }}" alt
                                                class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                                        </strong>&nbsp;&nbsp;•
                                        {{ \Carbon\Carbon::parse($item->time_post)->diffForHumans() }}
                                    </div>
                                    <div class="text-left d-block d-sm-none" data-bs-toggle="modal"
                                        data-bs-target="#akun{{ $item->id }}" style="cursor: pointer;">
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
                                                onclick="return save({{ $item->id }})"><i
                                                    class="fas fa-bookmark menu-icon"
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
                                            '/(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/)([^\&\?\/]+)/',
                                            $item->media,
                                            $matches,
                                        );
                                        $youtubeId = $matches[3] ?? null;
                                    @endphp
                                    @if ($youtubeId)
                                        <div class="d-none d-sm-block">
                                            <iframe style="max-width: 750px; min-width: 750px; height: 350px;"
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
                                    @endif
                                @elseif (strpos($item->media, '.jpg') !== false ||
                                        strpos($item->media, '.jpeg') !== false ||
                                        strpos($item->media, '.png') !== false ||
                                        strpos($item->media, 'data:image') !== false ||
                                        strpos($item->media, '.gif') !== false)
                                    <img src="{{ $item->media }}" alt="media gambar" class="img-fluid lazyload"
                                        style="height: 300px;">
                                @else
                                    @if (filter_var($item->media, FILTER_VALIDATE_URL))
                                        <div>
                                            <a href="{{ $item->media }}" target="_blank"
                                                class="btn btn-primary btn-sm">Read
                                                Article
                                                or
                                                View
                                                Material</a>
                                        </div>
                                    @elseif($item->media_file !== null)
                                        <img src="{{ asset('media/' . $item->media_file) }}" alt="media gambar"
                                            class="img-fluid lazyload" style="height: 300px;">
                                    @else
                                    @endif
                                @endif
                            </div>
                            <div class="text-left mt-4">
                                <h5 style="color: black; font-weight: bold;">{{ $item->judul }}</h5>
                            </div>
                            <div class="d-flex justify-content-start">
                                @if (Auth::user()->role == 'Pengamat')
                                    <div class="d-flex align-items-center me-3">
                                        <i class="fa fa-heart" style="font-size: 1.70em; color: red;"></i>
                                    </div>
                                    <div class="d-flex align-items-center me-3">
                                        <a href="{{ route('comment', $item->id) }}">
                                            <i class="fa fa-comment" style="font-size: 1.70em; color: #696cff;"></i>
                                        </a>
                                    </div>
                                @else
                                    @if ($item->liked)
                                        <div class="d-flex align-items-center me-3">
                                            <i class="fa fa-heart" style="font-size: 1.70em; cursor: pointer; color: red;"
                                                onclick="return like({{ $item->id }})"></i>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center me-3">
                                            <i class="fa fa-heart" style="font-size: 1.70em; cursor: pointer;"
                                                onclick="return like({{ $item->id }})"></i>
                                        </div>
                                    @endif
                                    <div class="d-flex align-items-center me-3">
                                        <a href="{{ route('comment', $item->id) }}">
                                            <i class="fa fa-comment" style="font-size: 1.70em; color: #696cff;"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="text-left mt-2">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#menyukai{{ $item->id }}">
                                    <span style="color: black; font-weight: bold;">{{ $item->like }}
                                        suka</span>
                                </a>

                            </div>
                            <div class="text-left mt-2">
                                {{-- <span id="deskripsi" style="color: black;">{!! $item->deskripsi !!}</span> --}}
                                @php
                                    $fullText = $item->deskripsi;
                                    $truncated = Str::limit(strip_tags($fullText), 500, '...');
                                    $isLong = strlen(strip_tags($fullText)) > 500;
                                    $uniqueId = 'description-' . $item->id;
                                @endphp
                                <div id="shortText-{{ $uniqueId }}" style="color: black;">
                                    {!! $truncated !!}
                                </div>
                                <div id="fullText-{{ $uniqueId }}" style="color: black; display: none;">
                                    {!! $fullText !!}
                                </div>
                                @if ($isLong)
                                    <a href="javascript:void(0);" onclick="toggleText('{{ $uniqueId }}')"
                                        id="readMoreBtn-{{ $uniqueId }}" style="color: red;">
                                        Baca Selengkapnya
                                    </a>
                                @endif
                            </div>
                            <div class="mt-1">
                                <div class="text-left">
                                    <a href="{{ route('comment', $item->id) }}">Lihat semua
                                        {{ $item->komen }}
                                        komentar</a>
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
                                                    {{ $k->nama }}
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
                                    <div class="d-flex justify-content-start">
                                        <form method="POST" action="{{ route('comment.insert') }}"
                                            enctype="multipart/form-data"
                                            class="d-flex align-items-left w-100 comment-form">
                                            @csrf
                                            <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                                            <input type="hidden" name="id_post" value="{{ $item->id }}">
                                            <div class="input-group me-2" style="flex: 1;">
                                                <span class="input-group-text bg-white border-0 p-0"
                                                    id="basic-addon1">
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
                                                <textarea name="comment" class="form-control" style="border-radius: 50px; margin-left: 10px;" id="komentar"
                                                    rows="1" placeholder="Add Comments...." required></textarea>
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
                                            <h4 style="font-weight: bold; color: black;">
                                                {{ $p->soal }}
                                            </h4>
                                        </div>
                                        <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    @php
                                                        $userVotedOption = null;
                                                        foreach ($jawaban as $a) {
                                                            if (
                                                                $a->id_post == $item->id &&
                                                                $a->poll_id == $p->id &&
                                                                $a->voted
                                                            ) {
                                                                $userVotedOption = $a->id;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    @foreach ($jawaban as $a)
                                                        @if ($a->id_post == $item->id && $a->poll_id == $p->id)
                                                            <div
                                                                class="mb-2 d-flex justify-content-between align-items-center">
                                                                <div class="form-check">
                                                                    @if ($userVotedOption !== null)
                                                                        <input type="radio"
                                                                            id="option{{ $a->id }}"
                                                                            name="poll{{ $p->id }}"
                                                                            class="form-check-input"
                                                                            {{ $userVotedOption == $a->id ? 'checked' : '' }}
                                                                            disabled>
                                                                    @else
                                                                        @if (Auth::user()->role === 'Pengamat')
                                                                            <input type="radio"
                                                                                id="option{{ $a->id }}"
                                                                                name="poll{{ $p->id }}"
                                                                                class="form-check-input" disabled>
                                                                        @else
                                                                            <input type="radio"
                                                                                id="option{{ $a->id }}"
                                                                                name="poll{{ $p->id }}"
                                                                                class="form-check-input"
                                                                                onclick="return vote({{ $a->id }})">
                                                                        @endif
                                                                    @endif
                                                                    <label class="form-check-label"
                                                                        for="option{{ $a->id }}">{{ $a->jawaban }}</label>
                                                                </div>
                                                                <span
                                                                    class="badge bg-primary">{{ $a->value }}</span>
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
                                                    <a href="{{ route('viewVote', $p->id) }}"
                                                        class="btn btn-success">View
                                                        votes</a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-block d-sm-none">
        <button id="refreshButton" class="refresh-button"data-bs-toggle="modal" data-bs-target="#searchPost"><i
                class="fa fa-search"></i></button>
    </div>
@endsection

@push('after-script')
    <script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function toggleText(uniqueId) {
            const shortText = document.getElementById('shortText-' + uniqueId);
            const fullText = document.getElementById('fullText-' + uniqueId);
            const readMoreBtn = document.getElementById('readMoreBtn-' + uniqueId);

            if (shortText.style.display === 'none') {
                shortText.style.display = 'block';
                fullText.style.display = 'none';
                readMoreBtn.textContent = 'Baca Selengkapnya';
            } else {
                shortText.style.display = 'none';
                fullText.style.display = 'block';
                readMoreBtn.textContent = 'Lebih Sedikit';
            }
        }
    </script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        searchInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.trim();

            if (searchTerm === '') {
                searchResults.innerHTML = '';
                return;
            }

            axios.get('/search', {
                    params: {
                        query: searchTerm
                    }
                })
                .then(response => {
                    displayResults(response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }, 300));

        function displayResults(results) {
            searchResults.innerHTML = '';
            if (results.length === 0) {
                searchResults.innerHTML = '<p>No results found.</p>';
            } else {
                const ul = document.createElement('ul');
                ul.className = 'list-unstyled';
                results.forEach(post => {
                    const li = document.createElement('li');
                    li.className = 'mb-2';
                    li.innerHTML = `
                <a href="/post/lihat/${post.id}" class="text-decoration-none">
                    <strong>${post.judul}</strong>
                    <br>
                    <small>${post.deskripsi.substring(0, 100)}...</small>
                </a>
            `;
                    ul.appendChild(li);
                });
                searchResults.appendChild(ul);
            }
        }

        function debounce(func, delay) {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            }
        }

        // Tambahkan event listener untuk menutup modal saat link diklik
        document.addEventListener('click', function(event) {
            if (event.target.closest('#searchResults a')) {
                $('#searchPost').modal('hide');
            }
        });
    </script>

    <script type="text/javascript">
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
            event.preventDefault();
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
            // var scrollPosition = $(window).scrollTop();
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
            // $(window).on('load', function() {
            //     $(window).scrollTop(scrollPosition);
            // });
            // return false;
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
        })
    </script>
@endpush
