@extends('layout.app')

@section('title', 'Chat - Pendar rasa')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endpush

@section('content')
    <div class="text-center" id="loading" style="margin-top: 240px;">
        <div class="spinner-border spinner-border-lg text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 border-end" style="height: 65vh; overflow-y: auto;">
                        <h4 class="p-3" style="color: black; font-weight:bold;">Chat List</h4>
                        <ul class="list-group">
                            @foreach ($data as $item)
                                <li class="list-group-item">
                                    <a href="#" class="text-decoration-none" style="color: black;">
                                        <p>{{ $item->nama }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="chat-window"
                            style="height: 65vh; overflow-y: auto; background-color: #f8f9fa; padding: 20px;">
                        </div>
                        <form id="chat-form">
                            @csrf
                            <div class="input-group mt-3">
                                <input type="text" name="message" class="form-control" id="message-input"
                                    placeholder="Type your message here..." required>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <form id="chat-form">
                <input type="text" id="message-input" placeholder="Tulis pesan...">
                <button type="submit">Kirim</button>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>id_user</th>
                        <th>pesan</th>
                    </tr>
                </thead>
                <tbody id="chat-body">
                    @foreach ($chat as $row)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $row->id_user }}</td>
                            <td>{{ $row->message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function refreshChat() {
            $.ajax({
                url: "{{ route('chat.json') }}", // URL untuk mendapatkan data chat
                type: 'GET',
                success: function(data) {
                    let tbody = '';
                    data.forEach(function(row, index) {
                        tbody += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.id_user}</td>
                                <td>${row.message}</td>
                            </tr>
                        `;
                    });
                    document.getElementById('chat-body').innerHTML = tbody;
                }
            });
        }

        // Refresh setiap 30 detik
        setInterval(refreshChat, 30000);
    </script>
    <script>
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();

            let message = document.getElementById('message-input').value;

            // Kirim data menggunakan axios
            axios.post('/send-message', {
                message: message
            }).then(response => {
                let data = response.data;

                // Dapatkan elemen tbody
                let chatBody = document.getElementById('chat-body');

                // Tambahkan pesan baru ke tbody
                let newRow = document.createElement('tr');
                let rowIndex = chatBody.rows.length + 1;

                newRow.innerHTML = `
                    <td>${rowIndex}</td>
                    <td>${data.id_user}</td>
                    <td>${data.message}</td>
                `;

                chatBody.appendChild(newRow); // Tambahkan baris baru ke tabel

                console.log('Pesan dikirim dan ditampilkan');
            }).catch(error => {
                console.error('Error:', error);
            });

            // Kosongkan input pesan setelah mengirim
            document.getElementById('message-input').value = '';
        });
    </script>
    <script>
        const wait = (delay = 0) =>
            new Promise(resolve => setTimeout(resolve, delay));

        const setVisible = (elementOrSelector, visible) =>
            (typeof elementOrSelector === 'string' ?
                document.querySelector(elementOrSelector) :
                elementOrSelector
            ).style.display = visible ? 'block' : 'none';

        setVisible('.card', false);
        setVisible('#loading', true);

        document.addEventListener('DOMContentLoaded', () =>
            wait(1000).then(() => {
                setVisible('.card', true);
                setVisible('#loading', false);
            }));
    </script>
@endpush
