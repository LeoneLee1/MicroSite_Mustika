@extends('layout.app')

@section('title', 'Chat - Pendar rasa')
@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endpush

@section('content')

@endsection


@push('after-script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function refreshChat() {
            $.ajax({
                url: "{{ route('chat.json') }}",
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
@endpush
