@extends('layout.app')

@section('title', 'Komentar - Pendarasa')

@push('after-style')
    <style>
        #komentar {
            flex-grow: 1;
            outline: none;
            border: none;
            background: transparent;
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

        .image-preview-container2 {
            width: 100px;
            background: #f8fafc;
            padding: 8px;
            border-radius: 10px;
            border: 1px dashed #e5e7eb;
        }

        .image-preview-wrapper2 {
            position: relative;
            display: inline-block;
            max-width: 150px;
            /* Reduced from 200px */
        }

        .image-preview-wrapper2 img {
            width: 80px;
            /* Fixed width */
            height: 80px;
            /* Fixed height */
            border-radius: 8px;
            object-fit: cover;
            /* This will maintain aspect ratio */
            border: 1px solid #e5e7eb;
        }

        .remove-image2 {
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

        .remove-image2:hover {
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
    <div class="card">
        <div class="card-body">
            <h4 class="text-center" style="color: black; font-weight: bold; margin-bottom: 50px">{{ $post->judul }}
            </h4>
            <div class="comments-section" style="max-height: 400px; overflow-y: auto; padding-right: 15px;">
                @if ($komen === null || collect($komen)->where('id_post', $post->id)->isEmpty())
                    <div class="text-center mb-4">
                        <h2>No Comments yet</h2>
                        <span>Start the conversation</span>
                    </div>
                @endif
                @foreach ($komen as $row)
                    @include('modal.akunKomen')
                    <div class="comment mb-4">
                        @if ($row->foto == '' || is_null($row->foto))
                            <div class="d-flex align-items-center justify-content-between" style="margin-bottom: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="text-left">
                                        <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                            alt class="w-px-30 h-auto rounded-circle lazyload" />
                                    </div>
                                    <div class="ms-2">
                                        <a href="javascript:void(0)"
                                            style="color: black; font-weight: bold; display: inline;" data-bs-toggle="modal"
                                            data-bs-target="#akunKomen{{ $row->id }}">
                                            {{ $row->nama }}
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <i class="fa fa-heart me-2 like-button" id="like-button{{ $row->id }}"
                                        data-comment-id="{{ $row->id }}" data-post-id="{{ $row->id_post }}"
                                        data-comment-text="{{ $row->comment }}"
                                        style="font-size: 17px; cursor: pointer; color: {{ Auth::user()->hasLikedComment($row->id) ? 'red' : 'grey' }};">
                                    </i>
                                    @if (Auth::user()->nik == 'daniel.it')
                                        <a href="{{ route('comment.delete', $row->id) }}" class="btn btn-sm btn-danger"
                                            onclick="return DeleteComment()"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="text-left mb-3" style="margin-left: 40px;">
                                <div class="mb-3">
                                    @if (strpos($row->clip, '.mp4') !== false ||
                                            strpos($row->clip, '.webm') !== false ||
                                            strpos($row->clip, '.MOV') !== false ||
                                            strpos($row->clip, '.ogg') !== false)
                                        <video controls class="img-fluid" style="max-width: 20%; height: auto;">
                                            <source src="{{ asset('clip/' . $row->clip) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        @if ($row->clip === null)
                                        @else
                                            <a href="{{ asset('clip/' . $row->clip) }}">
                                                <img src="{{ asset('clip/' . $row->clip) }}" alt="clip gambar"
                                                    class="img-fluid lazyload" style="height: 250px;">
                                            </a>
                                        @endif
                                    @endif
                                </div>
                                <p style="color: black;">{!! nl2br(e($row->comment)) !!}</p>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-between" style="margin-bottom: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="text-left">
                                        @if ($row->foto == '' || null)
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt class="w-px-30 h-auto rounded-circle lazyload" />
                                        @else
                                            <img src="{{ asset('img/foto/' . $row->foto) }}" alt
                                                class="w-px-30 h-auto rounded-circle lazyload" />
                                        @endif
                                    </div>
                                    <div class="ms-2">
                                        <a href="javascript:void(0)"
                                            style="color: black; font-weight: bold; display: inline;" data-bs-toggle="modal"
                                            data-bs-target="#akunKomen{{ $row->id }}">
                                            {{ $row->nama }}
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <i class="fa fa-heart me-2 like-button" id="like-button{{ $row->id }}"
                                        data-comment-id="{{ $row->id }}" data-post-id="{{ $row->id_post }}"
                                        data-comment-text="{{ $row->comment }}"
                                        style="font-size: 17px; cursor: pointer; color: {{ Auth::user()->hasLikedComment($row->id) ? 'red' : 'grey' }};">
                                    </i>
                                    @if (Auth::user()->nik == 'daniel.it')
                                        <a href="{{ route('comment.delete', $row->id) }}" class="btn btn-sm btn-danger"
                                            onclick="return DeleteComment()"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="text-left mb-3" style="margin-left: 40px;">
                                <div class="mb-3">
                                    @if (strpos($row->clip, '.mp4') !== false ||
                                            strpos($row->clip, '.webm') !== false ||
                                            strpos($row->clip, '.MOV') !== false ||
                                            strpos($row->clip, '.ogg') !== false)
                                        <video controls class="img-fluid" style="max-width: 20%; height: auto;">
                                            <source src="{{ asset('clip/' . $row->clip) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        @if ($row->clip === null)
                                        @else
                                            <a href="{{ asset('clip/' . $row->clip) }}">
                                                <img src="{{ asset('clip/' . $row->clip) }}" alt="clip gambar"
                                                    class="img-fluid lazyload" style="height: 250px;">
                                            </a>
                                        @endif
                                    @endif
                                </div>
                                <p style="color: black;">{!! nl2br(e($row->comment)) !!}</p>
                            </div>
                        @endif
                        <div class="d-inline-flex" style="margin-left: 40px;">
                            <p style="margin-right: 10px;">
                                {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</p>
                            <p style="margin-right: 10px; color: #818f9f; cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#likeComment{{ $row->id }}" id="like-count{{ $row->id }}">
                                {{ $row->likes }} suka</p>
                            @include('modal.menyukaiKomen')
                            @if (Auth::user()->role === 'Pengamat')
                            @else
                                <a href="javascript:void(0);" class="reply-button" data-comment-id="{{ $row->id }}"
                                    style="margin-right: 10px; color: #818f9f;">Balas</a>
                            @endif
                        </div>
                        <div class="reply-form-container d-none mb-3" style="margin-left: 40px;">
                            <form action="{{ route('comment.balas') }}" method="POST"
                                class="d-flex align-items-center w-100 reply-form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                                <input type="hidden" name="id_post" value="{{ $row->post_id }}">
                                <input type="hidden" name="id_comment" value="{{ $row->id }}">
                                <div class="input-group me-2" style="flex: 1;">
                                    <div class="image-preview-container2" id="imagePreviewContainer2_{{ $row->id }}"
                                        style="display: none;">
                                        <div class="image-preview-wrapper2">
                                            <img id="imagePreview2_{{ $row->id }}" src="" alt="Preview">
                                            <button type="button" class="remove-image2"
                                                onclick="removeImage2({{ $row->id }})">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <textarea name="comment" id="reply-input" class="form-control" style="border-radius: 50px;" rows="1"
                                        placeholder="Add Reply...." required></textarea>
                                </div>
                                <input type="file" name="clip" id="buttonFile2_{{ $row->id }}" hidden>
                                <button type="button" class="btn btn-danger btn-sm me-1" title="PICTURE/VIDEO"
                                    style="border-radius: 50px;"
                                    onclick="document.getElementById('buttonFile2_{{ $row->id }}').click();"><i
                                        class="fa fa-paperclip"></i></button>
                                <button type="submit" class="btn btn-primary btn-sm me-2"
                                    style="border-radius: 50px;">Send</button>
                            </form>
                        </div>
                        @if ($countReplies === null || collect($countReplies)->where('id_comment', $row->id)->isEmpty())
                        @else
                            <div class="mb-2">
                                <div class="d-inline-flex">
                                    <p style="margin-right: 10px; margin-left: 40px;">-----</p>
                                    @foreach ($countReplies as $total)
                                        @if ($total->id_comment == $row->id)
                                            <p class="toggle-replies" data-comment-id="{{ $row->id }}"
                                                style="cursor: pointer;">Lihat
                                                balasan ({{ $total->total }})</p>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="replies-container" id="replies-{{ $row->id }}" style="display: none;">
                                    @foreach ($replies as $item)
                                        @if ($item->id_comment == $row->id)
                                            @include('modal.akunBalasKomen')
                                            <div class="mb-2">
                                                <div style="margin-left: 39px;">
                                                    <div class="d-flex align-items-center justify-content-between"
                                                        style="margin-bottom: 10px;">
                                                        <div class="d-flex align-items-center">
                                                            <div class="text-left">
                                                                @if ($item->foto == '' || null)
                                                                    <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                                        alt
                                                                        class="w-px-30 h-auto rounded-circle lazyload" />
                                                                @else
                                                                    <img src="{{ asset('img/foto/' . $item->foto) }}" alt
                                                                        class="w-px-30 h-auto rounded-circle lazyload" />
                                                                @endif
                                                            </div>
                                                            <div class="ms-2">
                                                                <a href="javascript:void(0)"
                                                                    style="color: black; font-weight: bold; display: inline;"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#akunKomenBalas{{ $item->id }}">
                                                                    {{ $item->nama }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-left mb-3" style="margin-left: 40px;">
                                                        <div class="mb-3">
                                                            @if (strpos($item->clip, '.mp4') !== false ||
                                                                    strpos($item->clip, '.webm') !== false ||
                                                                    strpos($item->clip, '.MOV') !== false ||
                                                                    strpos($item->clip, '.ogg') !== false)
                                                                <video controls class="img-fluid"
                                                                    style="max-width: 20%; height: auto;">
                                                                    <source src="{{ asset('clip/' . $item->clip) }}"
                                                                        type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            @else
                                                                @if ($item->clip === null)
                                                                @else
                                                                    <a href="{{ asset('clip/' . $item->clip) }}">
                                                                        <img src="{{ asset('clip/' . $item->clip) }}"
                                                                            alt="clip gambar" class="img-fluid lazyload"
                                                                            style="height: 250px;">
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <p style="color: black;">{!! nl2br(e($item->comment)) !!}</p>
                                                    </div>
                                                </div>
                                                <div class="d-inline-flex" style="margin-left: 78px;">
                                                    <p style="margin-right: 10px;">
                                                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @if (Auth::user()->role == 'Pengamat')
            @else
                <div class="d-flex justify-content-start">
                    <form action="{{ route('comment.insert') }}" method="POST"
                        class="d-flex align-items-center w-100 comment-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                        <input type="hidden" name="id_post" value="{{ $post->id }}">
                        <div class="input-group me-2" style="flex: 1;">
                            <span class="input-group-text bg-white border-0 p-0" id="basic-addon1">
                                @if (Auth::user()->foto == '' || null)
                                    <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                        alt="User Avatar" class="w-px-30 h-auto rounded-circle lazyload"
                                        style="object-fit: cover;" />
                                @else
                                    <img src="{{ asset('img/foto/' . Auth::user()->foto) }}" alt="User Avatar"
                                        class="w-px-30 h-auto rounded-circle lazyload" style="object-fit: cover;" />
                                @endif
                            </span>
                            <div class="image-preview-container" id="imagePreviewContainer" style="display: none;">
                                <div class="image-preview-wrapper">
                                    <img id="imagePreview" src="" alt="Preview">
                                    <button type="button" class="remove-image" onclick="removeImage()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <textarea name="comment" class="form-control" style="border-radius: 50px;" id="komentar" rows="1"
                                placeholder="Add Comments...." required></textarea>
                        </div>
                        <input type="file" name="clip" id="buttonFile" hidden>
                        <button type="button" class="btn btn-danger btn-sm me-1" title="PICTURE/VIDEO"
                            style="border-radius: 50px;" onclick="document.getElementById('buttonFile').click();"><i
                                class="fa fa-paperclip"></i></button>
                        <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 50px;">Send</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        function handleFileChange(id) {
            document.getElementById(`buttonFile2_${id}`).addEventListener('change', function(event) {
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
                        const previewContainer = document.getElementById(`imagePreviewContainer2_${id}`);
                        const previewImage = document.getElementById(`imagePreview2_${id}`);

                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                        document.getElementById('fileClick2').style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        function removeImage2(id) {
            const fileInput = document.getElementById(`buttonFile2_${id}`);
            const previewContainer = document.getElementById(`imagePreviewContainer2_${id}`);
            const previewImage = document.getElementById(`imagePreview2_${id}`);

            fileInput.value = '';
            previewImage.src = '';
            previewContainer.style.display = 'none';
            document.getElementById('fileClick2').style.display = 'block';
        }

        @foreach ($komen as $row)
            handleFileChange({{ $row->id }});
        @endforeach
    </script>
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

            fileInput.value = '';
            previewImage.src = '';
            previewContainer.style.display = 'none';
            document.getElementById('fileClick').style.display = 'block';
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.like-button').click(function() {
                var commentId = $(this).data('comment-id');
                var postId = $(this).data('post-id');
                var commentText = $(this).data('comment-text');
                var likeCount = $('#like-count' + commentId);
                var icon = $(this);

                if (icon.css('color') === 'rgb(255, 0, 0)') {
                    $.ajax({
                        url: "{{ route('comment.unlike') }}",
                        method: 'POST',
                        data: {
                            id_comment: commentId,
                            id_post: postId,
                            comment: commentText,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            icon.css('color', 'grey');
                            likeCount.text(parseInt(likeCount.text()) - 1 + " suka");
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ route('comment.like') }}",
                        method: 'POST',
                        data: {
                            id_comment: commentId,
                            id_post: postId,
                            comment: commentText,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            icon.css('color', 'red');
                            likeCount.text(parseInt(likeCount.text()) + 1 + " suka");
                        }
                    });
                }
            });
        });
    </script>
    <script>
        function DeleteComment() {
            if (confirm('Hapus??')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Handle "Lihat balasan" click
            $('.toggle-replies').on('click', function() {
                var commentId = $(this).data('comment-id');
                var repliesContainer = $('#replies-' + commentId);

                // Toggle visibility of the replies container
                repliesContainer.toggle();

                // Change the text of the toggle button
                if (repliesContainer.is(':visible')) {
                    $(this).text('Sembunyikan balasan (' + repliesContainer.find('.mb-2').length + ')');
                } else {
                    $(this).text('Lihat balasan (' + repliesContainer.find('.mb-2').length + ')');
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Handle reply button click
            $('.reply-button').on('click', function() {
                var commentId = $(this).data('comment-id');
                var replyFormContainer = $(this).closest('.comment').find('.reply-form-container');
                var viewRepliesLink = $(this).closest('.comment').find('.view-replies-link');

                // Remove any open reply form from another comment
                $('.reply-form-container').not(replyFormContainer).addClass('d-none');

                // Toggle visibility of the reply form for the current comment
                replyFormContainer.toggleClass('d-none');

                // If showing the form, move it above the "View replies" link
                if (!replyFormContainer.hasClass('d-none')) {
                    replyFormContainer.insertBefore(viewRepliesLink);

                    // Set the parent comment ID in the hidden input
                    replyFormContainer.find('input[name="id_comment"]').val(commentId);

                    // Scroll to the reply form
                    $('html, body').animate({
                        scrollTop: replyFormContainer.offset().top - 100
                    }, 500);
                }
            });
        });
    </script>
    <script>
        function confirmDelete() {
            if (confirm("Apakah kamu yakin ingin menghapus?")) {
                console.log("Delete confirmed!");
                return true;
            } else {
                console.log("Delete canceled!");
                return false;
            }
        }
    </script>
@endpush
