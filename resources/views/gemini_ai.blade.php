@extends('layout.app')

@section('title', 'Pendarrasa - Ask Gemini AI')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/gemini_container.css') }}">
@endpush

@section('navbar-item')
    <a href="/beranda" class="back-button btn-sm">
        <i class="fa fa-arrow-left"></i>
        <span class="d-none d-sm-block">Back</span>
    </a>
@endsection

@section('content')
    <div class="container py-4">
        <div class="chat-container">
            <div class="chat-card">
                <div class="chat-header">
                    <div class="d-flex justify-content-between aligns-item-center">
                        <h5 style="color: white;">
                            <i class="fas fa-robot mr-2"></i>
                            AI Chat Assistant
                        </h5>
                        <a href="{{ route('clear.chat', Auth::user()->nik) }}" class="delete-button btn-sm"
                            onclick="return confirmClearChat()">Clear Chat</a>
                    </div>
                </div>
                <div class="chat-messages" id="chat-messages">
                    @if (
                        $data === null ||
                            collect($data)->where('nik', Auth::user()->nik)->isEmpty())
                        <div class="welcome-container">
                            <div class="welcome-message">
                                <div class="wave-text">
                                    @foreach (str_split('Hello,') as $letter)
                                        <span class="wave-letter">{{ $letter }}</span>
                                    @endforeach
                                </div>
                                <div class="user-name">
                                    {{ Auth::user()->nama }}
                                </div>
                                <div class="welcome-subtitle">
                                    Start your conversation with AI
                                </div>
                                <div class="welcome-icon">
                                    <i class="fas fa-robot"></i>
                                </div>
                            </div>
                        </div>
                    @endif
                    @foreach ($data as $item)
                        @if ($item->nik === Auth::user()->nik)
                            <div class="message user-message">
                                @if ($item->image !== '')
                                    <img src="{{ asset('chatAI/' . $item->image) }}" alt="image" style="width: 250px;"
                                        class="img-fluid lazyload mb-4">
                                @endif
                                <p><strong>You</strong> {{ $item->question }}</p>
                            </div>
                            <div class="message ai-message" id="response">
                                <p><strong>AI Assistant</strong> <span class="typing-animation"
                                        style="color: black;">{!! nl2br(trim(strip_tags(str_replace(['**', '**', '*'], '', $item->text)))) !!}
                                    </span>
                                </p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="chat-input">
                    <form action="{{ route('ask_ai') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="chat-input-wrapper">
                            <div class="image-preview-container" id="imagePreviewContainer" style="display: none;">
                                <div class="image-preview-wrapper">
                                    <img id="imagePreview" src="" alt="Preview">
                                    <button type="button" class="remove-image" onclick="removeImage()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="file" name="image" id="buttonFile" hidden accept="image/*">
                            <button type="button" class="attachment-btn btn-sm"
                                onclick="document.getElementById('buttonFile').click();" id="fileClick">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48" />
                                </svg>
                            </button>
                            <textarea name="text" class="form-control" placeholder="Type your message here..." id="chat-input" rows="1"
                                autocomplete="off"></textarea>
                            <button class="btn btn-sm" id="send-message" type="submit">
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        document.getElementById('buttonFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                // Check if file is an image
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    this.value = '';
                    return;
                }

                // Check file size (e.g., 5MB limit)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
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

                    // Scroll chat to bottom to show new preview
                    const chatMessages = document.getElementById('chat-messages');
                    setTimeout(() => {
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }, 100);
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
        function confirmClearChat() {
            if (confirm('Bersihkan Chat?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    <script>
        // Auto-resize textarea
        document.getElementById('chat-input').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';

            if (this.value === '') {
                this.style.height = '60px';
            }

            if (this.scrollHeight > 150) {
                this.style.height = '150px';
            }
        });

        // Submit on Ctrl/Cmd + Enter
        document.getElementById('chat-input').addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                document.getElementById('send-message').click();
            }
        });

        // Auto scroll to bottom when new messages arrive
        function scrollToBottom() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Call scrollToBottom when page loads and when new messages are added
        window.onload = scrollToBottom;
        // You should also call scrollToBottom whenever a new message is added
    </script>
@endpush
