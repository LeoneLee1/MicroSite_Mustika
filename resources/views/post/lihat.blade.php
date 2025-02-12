@extends('layout.app')

@section('title', 'Post - Pendarasa')

@push('after-style')
    <style>
        input[type="radio"]:disabled {
            opacity: 1 !important;
            cursor: not-allowed;
        }

        input[type="radio"]:disabled+label {
            color: #000000;
        }

        .slide-container {
            position: relative;
            max-width: 750px;
            margin: auto;
        }

        .mySlides {
            display: none;
            text-align: center;
        }

        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: auto;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 30%;
            background-color: rgba(0, 0, 0, 0.5);
            user-select: none;
            z-index: 10;
        }

        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
            transition: all 0.3s ease;
            border-radius: 50%;
            background: linear-gradient(145deg, #2a2a2a, #404040);
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5),
                -5px -5px 10px rgba(255, 255, 255, 0.1);
            z-index: 10;
        }

        .prev {
            left: -40px;
        }

        .next {
            right: -40px;
        }

        .prev:hover,
        .next:hover {
            background: linear-gradient(145deg, #404040, #2a2a2a);
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.6),
                -5px -5px 15px rgba(255, 255, 255, 0.15);
            transform: translateY(-50%) scale(1.1);
        }

        .prev span,
        .next span {
            transition: transform 0.3s ease;
        }

        .prev:hover span {
            transform: translateX(-5px);
        }

        .next:hover span {
            transform: translateX(5px);
        }

        .prev:active,
        .next:active {
            transform: translateY(-50%) scale(0.95);
        }

        .back-button {
            background-color: #ffffff;
            color: #6366f1;
            border: 2px solid #6366f1;
            border-radius: 20px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-button:hover {
            background-color: #6366f1;
            color: white;
        }

        .image-preview-container {
            width: 100px;
            background: #f8fafc;
            padding: 8px;
            border-radius: 10px;
            border: 1px dashed #e5e7eb;
        }

        .image-preview-wrapper {
            position: relative;
            display: inline-block;
            max-width: 150px;
            /* Reduced from 200px */
        }

        .image-preview-wrapper img {
            width: 80px;
            /* Fixed width */
            height: 80px;
            /* Fixed height */
            border-radius: 8px;
            object-fit: cover;
            /* This will maintain aspect ratio */
            border: 1px solid #e5e7eb;
        }

        .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 0;
            font-size: 10px;
        }

        .remove-image:hover {
            background: #cc0000;
            transform: scale(1.1);
        }
    </style>
@endpush

@section('navbar-item')
    <a href="javascript:void(0)" class="back-button btn-sm" onclick="window.history.go(-1); return false;">
        <i class="fa fa-arrow-left"></i>
        <span class="d-none d-sm-block">Back</span>
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        @foreach ($data as $item)
            @include('modal.akunLihat')
            <div class="card mb-3" style="width: 55rem;">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            @if ($item->foto == '' || null)
                                <div class="text-left d-none d-sm-block" data-bs-toggle="modal"
                                    data-bs-target="#akunLihat{{ $item->id }}" style="cursor: pointer;">
                                    <strong style="color: black;">
                                        <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                            alt
                                            class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;{{ $item->nama }}
                                    </strong>&nbsp;&nbsp;•
                                    {{ \Carbon\Carbon::parse($item->time_post)->diffForHumans() }}
                                </div>
                                <div class="text-left d-block d-sm-none" data-bs-toggle="modal"
                                    data-bs-target="#akunLihat{{ $item->id }}" style="cursor: pointer;">
                                    <strong style="color: black;">
                                        <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                            alt
                                            class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;{{ $item->nama }}
                                    </strong>
                                </div>
                            @else
                                <div class="text-left d-none d-sm-block" data-bs-toggle="modal"
                                    data-bs-target="#akunLihat{{ $item->id }}" style="cursor: pointer;">
                                    <strong style="color: black;">
                                        <img src="{{ asset('img/foto/' . $item->foto) }}" alt
                                            class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;{{ $item->nama }}
                                    </strong>&nbsp;&nbsp;•
                                    {{ \Carbon\Carbon::parse($item->time_post)->diffForHumans() }}
                                </div>
                                <div class="text-left d-block d-sm-none" data-bs-toggle="modal"
                                    data-bs-target="#akunLihat{{ $item->id }}" style="cursor: pointer;">
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
                            <div class="slide-container" id="slide-container-{{ $item->id }}">
                                @foreach ($post_gambar as $row)
                                    @if ($row->id_post == $item->id)
                                        <div class="mySlides" data-slide-id="{{ $item->id }}">
                                            @if (strpos($row->media, '.mp4') !== false ||
                                                    strpos($row->media, '.webm') !== false ||
                                                    strpos($row->media, '.ogg') !== false)
                                                <video controls class="img-fluid" style="max-width: 50%; height: auto;">
                                                    <source src="{{ asset('media/' . $row->media) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @elseif (strpos($row->media, 'youtube.com') !== false || strpos($row->media, 'youtu.be') !== false)
                                                @php
                                                    preg_match(
                                                        '/(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/)([^\&\?\/]+)/',
                                                        $row->media,
                                                        $matches,
                                                    );
                                                    $youtubeId = $matches[3] ?? null;
                                                @endphp
                                                @if ($youtubeId)
                                                    <div class="d-none d-sm-block">
                                                        <iframe style="max-width: 750px; min-width: 750px; height: 350px;"
                                                            src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen class="img-fluid lazyload"></iframe>
                                                    </div>
                                                    <div class="d-block d-sm-none">
                                                        <iframe style="max-width: 260px; min-width: 260px; height: 200px;"
                                                            src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen class="img-fluid lazyload"></iframe>
                                                    </div>
                                                @endif
                                            @else
                                                @if ($row->media === null)
                                                @else
                                                    <a href="{{ asset('media/' . $row->media) }}">
                                                        <img src="{{ asset('media/' . $row->media) }}" alt="media gambar"
                                                            class="img-fluid lazyload" style="height: 300px;">
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                                <a class="prev" onclick="plusSlides(-1, {{ $item->id }})">
                                    <span style="color: #ffffff;">&#10094;</span>
                                </a>
                                <a class="next" onclick="plusSlides(1, {{ $item->id }})">
                                    <span style="color: #ffffff;">&#10095;</span>
                                </a>
                            </div>
                        </div>
                        <div class="text-left mt-4">
                            <h5 style="color: black; font-weight: bold;">{{ $item->judul }}</h5>
                        </div>
                        <div class="d-flex justify-content-start">
                            @if (Auth::user()->role == 'Pengamat')
                                <div class="d-flex align-items-center me-3">
                                    <i class="fa fa-heart" style="font-size: 1.70em; color: grey;"></i>
                                </div>
                                <div class="d-flex align-items-center me-3">
                                    <a href="{{ route('comment', $item->id) }}">
                                        <i class="fa fa-comment" style="font-size: 1.70em; color: #696cff;"></i>
                                    </a>
                                </div>
                            @else
                                <div class="d-flex align-items-center me-3">
                                    <i class="fa fa-heart me-2 like-button" id="like-button{{ $item->id }}"
                                        data-post-id="{{ $item->id }}"
                                        style="font-size: 1.70rem; cursor: pointer; color: {{ Auth::user()->hasLiked($item->id) ? 'red' : 'grey' }};">
                                    </i>
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#menyukai{{ $item->id }}">
                                        <span style="color: black; font-weight: bold;"
                                            id="like-count{{ $item->id }}">{{ $item->like }}</span>
                                    </a>
                                </div>
                                <div class="d-flex align-items-center me-3">
                                    <a href="{{ route('comment', $item->id) }}">
                                        <i class="fa fa-comment" style="font-size: 1.70em; color: #696cff;"></i>
                                    </a>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('analyze', $item->id) }}" class="btn btn-sm btn-danger"
                                        onclick="askAI()" id="buttonTanyaAI">Tanya
                                        AI</a>
                                    <button class="buttonload btn btn-danger" style="display: none;">
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="text-left mt-2">
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
                                            <div class="image-preview-container" id="imagePreviewContainer"
                                                style="display: none;">
                                                <div class="image-preview-wrapper">
                                                    <img id="imagePreview" src="" alt="Preview">
                                                    <button type="button" class="remove-image"
                                                        onclick="removeImage()">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <textarea name="comment" class="form-control" style="border-radius: 50px; margin-left: 10px;" id="komentar"
                                                rows="1" placeholder="Add Comments...." required></textarea>
                                        </div>
                                        <input type="file" name="clip" id="buttonFile" hidden>
                                        <button type="button" class="btn btn-danger btn-sm me-1"
                                            title="PICTURE/VIDEO" style="border-radius: 50px;"
                                            onclick="document.getElementById('buttonFile').click();"><i
                                                class="fa fa-paperclip"></i></button>
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
                                                @foreach ($jawaban as $a)
                                                    @if ($a->id_post == $item->id && $a->poll_id == $p->id)
                                                        @php
                                                            $userVotedPoll = DB::table('answer_vote')
                                                                ->where('nik', Auth::user()->nik)
                                                                ->where('poll_id', $a->poll_id)
                                                                ->exists();

                                                            $userVote = DB::table('answer_vote')
                                                                ->where('nik', Auth::user()->nik)
                                                                ->where('poll_id', $a->poll_id)
                                                                ->where('id_post', $a->id_post)
                                                                ->where('id_jawaban', $a->id)
                                                                ->exists();
                                                        @endphp
                                                        <div
                                                            class="mb-2 d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="vote{{ $a->id }}"
                                                                    data-answer-id="{{ $a->id }}"
                                                                    data-poll-id="{{ $a->poll_id }}"
                                                                    data-post-id="{{ $a->id_post }}"
                                                                    data-answer="{{ $a->jawaban }}"
                                                                    {{ $userVotedPoll ? 'disabled' : '' }}
                                                                    {{ $userVote ? 'checked' : '' }}>
                                                                @if (Auth::user()->role === 'Pengamat')
                                                                    <input type="radio" class="form-check-input"
                                                                        disabled>
                                                                @endif
                                                                <label
                                                                    class="form-check-label">{{ $a->jawaban }}</label>
                                                            </div>
                                                            <span class="badge bg-primary"
                                                                id="vote-count{{ $a->id }}">{{ $a->value }}</span>
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
@endsection

@push('after-script')
<script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('buttonFile').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {

            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('File size should not exceed 5MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.getElementById('imagePreviewContainer');
                const previewImage = document.getElementById('imagePreview');

                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
                document.getElementById('fileClick').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    function removeImage() {
        const fileInput = document.getElementById('buttonFile');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');

        fileInput.value = ''; // Clear file input
        previewImage.src = ''; // Clear preview
        previewContainer.style.display = 'none'; // Hide preview container
        document.getElementById('fileClick').style.display = 'block';
    }
</script>
<script>
    function plusSlides(n, id) {
        const container = document.getElementById(`slide-container-${id}`);
        const slides = container.querySelectorAll(`[data-slide-id="${id}"]`);
        let slideIndex = parseInt(container.getAttribute("data-slide-index")) || 1;

        slideIndex += n;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }
        if (slideIndex < 1) {
            slideIndex = slides.length;
        }

        container.setAttribute("data-slide-index", slideIndex);

        slides.forEach((slide) => (slide.style.display = "none"));
        slides[slideIndex - 1].style.display = "block";
    }

    document.querySelectorAll(".slide-container").forEach((container) => {
        container.setAttribute("data-slide-index", 1);
        const slides = container.querySelectorAll(`[data-slide-id]`);
        if (slides.length > 0) slides[0].style.display = "block";
        const prev = container.querySelector(".prev");
        const next = container.querySelector(".next");
        if (slides.length <= 1) {
            if (prev) prev.style.display = "none";
            if (next) next.style.display = "none";
        }
    });
</script>
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
    $(document).ready(function() {
        $('.like-button').click(function() {
            var postId = $(this).data('post-id');
            var icon = $(this);
            var likeCount = $('#like-count' + postId);

            if (icon.css('color') === 'rgb(255, 0, 0)') {
                $.ajax({
                    url: "{{ route('unlike') }}",
                    method: 'POST',
                    data: {
                        id_post: postId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        icon.css('color', 'grey');
                        likeCount.text(parseInt(likeCount.text()) - 1);
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('like') }}",
                    method: 'POST',
                    data: {
                        id_post: postId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        icon.css('color', 'red');
                        likeCount.text(parseInt(likeCount.text()) + 1);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('input[type="radio"].form-check-input').click(function() {
            var answerId = $(this).data('answer-id');
            var pollId = $(this).data('poll-id');
            var postId = $(this).data('post-id');
            var jawaban = $(this).data('answer');
            var voteCount = $('#vote-count' + answerId);
            var input = $(this);

            if (input.prop('disabled')) {
                return;
            }

            $.ajax({
                url: "{{ route('vote') }}",
                method: 'POST',
                data: {
                    poll_id: pollId,
                    id_jawaban: answerId,
                    id_post: postId,
                    jawaban: jawaban,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        input.prop('checked', true);
                        voteCount.text(parseInt(voteCount.text()) + 1);
                        $('input[type="radio"][data-poll-id="' + pollId + '"]').prop(
                            'disabled', true);
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    });
</script>
{{-- <script type="text/javascript">
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
</script> --}}
@endpush
