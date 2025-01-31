@extends('layout.app')

@section('title', 'Pendarrasa - Ask Gemini AI')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/gemini_container.css') }}">
@endpush

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
                            <div class="message user-message" id="scrollableDiv">
                                @if ($item->image !== '')
                                    <img src="{{ asset('chatAI/' . $item->image) }}" alt="image" style="width: auto;"
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
                            <input type="file" name="image" id="buttonFile" accept="image/*" hidden>
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
                            <button class="buttonload" style="display: none;">
                                <i class="fa fa-spinner fa-spin"></i>
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
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();

                $('.buttonload').show();

                $('#send-message').hide();
                $('#send-message').prop('disabled', true);

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.buttonload').hide();
                        $('#send-message').prop('disabled', false);
                        console.log(response);
                        window.location.reload();
                    },
                    error: function(xhr) {
                        $('.buttonload').hide();
                        $('#send-message').prop('disabled', false);
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('paste', event => {
            const file = event.clipboardData.files[0];

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

                const formFile = document.getElementById('buttonFile');
                if (formFile) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    formFile.files = dataTransfer.files;
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
        document.addEventListener("DOMContentLoaded", function() {
            const chatMessages = document.getElementById('chat-messages');

            function scrollToBottom() {
                setTimeout(() => {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 50);
            }

            scrollToBottom();

            const observer = new MutationObserver(() => {
                scrollToBottom();
            });

            observer.observe(chatMessages, {
                childList: true,
                subtree: true
            });

            var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator
                .userAgent);

            if (isMobile) {
                console.log("Anda dalam keadaan Mobile Device hehe");
            } else {
                document.getElementById('chat-input').addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        document.getElementById('send-message').click();
                        scrollToBottom();
                    }
                });
            }

            // Auto resize textarea
            document.getElementById('chat-input').addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';

                if (this.scrollHeight > 150) {
                    this.style.height = '150px';
                }
            });
        });
    </script>
@endpush
