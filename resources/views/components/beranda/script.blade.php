<script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="js/slideshow.js"></script>
<script>
    function askAI() {
        $('.buttonload').show();
        $('#buttonTanyaAI').hide();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('autoShowModal'));
        myModal.show();
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
            var postId = $(this).data('post-id'); // Ambil ID postingan dari atribut data
            var icon = $(this);
            var likeCount = $('#like-count' + postId); // Ambil elemen jumlah like yang sesuai

            if (icon.css('color') === 'rgb(255, 0, 0)') { // Jika sudah di-like (merah)
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
            } else { // Jika belum di-like (abu-abu)
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
