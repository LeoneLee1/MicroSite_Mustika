<!-- Modal -->
<div class="modal fade" id="searchPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex align-items-center">
                    <i class="fa fa-search"></i>
                    <input type="text" id="searchInput" class="form-control border-0 shadow-none"
                        placeholder="Search..." aria-label="Search...">
                </div>
            </div>
            <div id="searchResults" class="container"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
