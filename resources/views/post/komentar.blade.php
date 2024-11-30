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
    </style>
@endpush

@section('navbar-item')
    <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-sm btn-info"><i
            class="fa fa-arrow-left"></i>&nbsp;Back</a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col col-18 col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center" style="color: black; font-weight: bold; margin-bottom: 50px">{{ $post->judul }}
                    </h4>
                    <div class="comments-section" style="max-height: 400px; overflow-y: auto; padding-right: 15px;">
                        @if (
                            $komen === null ||
                                collect($komen)->where('id_post', $post->id)->isEmpty())
                            <div class="text-center mb-4">
                                <h2>No Comments yet</h2>
                                <span>Start the conversation</span>
                            </div>
                        @endif
                        @foreach ($komen as $row)
                            @include('modal.akunKomen')
                            <div class="comment mb-4">
                                @if ($row->foto == '' || is_null($row->foto))
                                    <div class="d-flex align-items-center justify-content-between"
                                        style="margin-bottom: 10px;">
                                        <div class="d-flex align-items-center">
                                            <div class="text-left">
                                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                    alt class="w-px-30 h-auto rounded-circle lazyload" />
                                            </div>
                                            <div class="ms-2">
                                                <a href="javascript:void(0)"
                                                    style="color: black; font-weight: bold; display: inline;"
                                                    data-bs-toggle="modal" data-bs-target="#akunKomen{{ $row->id }}">
                                                    {{ $row->nama }}
                                                </a>
                                                <span style="color: black;">{!! nl2br(e($row->comment)) !!}</span>
                                            </div>
                                        </div>
                                        <div>
                                            @if ($row->liked)
                                                <i class="fa fa-heart" onclick="return like({{ $row->id }})"
                                                    style="color: red; cursor: pointer;"></i>
                                            @else
                                                <i class="fa fa-heart" onclick="return like({{ $row->id }})"
                                                    style="cursor: pointer;"></i>
                                            @endif
                                            @if (Auth::user()->nik == 'daniel.it')
                                                <a href="{{ route('comment.delete', $row->id) }}"
                                                    class="btn btn-sm btn-danger" onclick="return DeleteComment()"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center justify-content-between"
                                        style="margin-bottom: 10px;">
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
                                                    style="color: black; font-weight: bold; display: inline;"
                                                    data-bs-toggle="modal" data-bs-target="#akunKomen{{ $row->id }}">
                                                    {{ $row->nama }}
                                                </a>
                                                <span style="color: black;">{!! nl2br(e($row->comment)) !!}</span>
                                            </div>
                                        </div>
                                        <div>
                                            @if ($row->liked)
                                                <i class="fa fa-heart" onclick="return like({{ $row->id }})"
                                                    style="color: red; cursor: pointer;"></i>
                                            @else
                                                <i class="fa fa-heart" onclick="return like({{ $row->id }})"
                                                    style="cursor: pointer;"></i>
                                            @endif
                                            @if (Auth::user()->nik == 'daniel.it')
                                                <a href="{{ route('comment.delete', $row->id) }}"
                                                    class="btn btn-sm btn-danger" onclick="return DeleteComment()"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="d-inline-flex" style="margin-left: 40px;">
                                    <p style="margin-right: 10px;">
                                        {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</p>
                                    <p style="margin-right: 10px; color: #818f9f; cursor: pointer;" data-bs-toggle="modal"
                                        data-bs-target="#likeComment{{ $row->id }}">{{ $row->likes }} suka</p>
                                    @include('modal.menyukaiKomen')
                                    <a href="javascript:void(0);" class="reply-button"
                                        data-comment-id="{{ $row->id }}"
                                        style="margin-right: 10px; color: #818f9f;">Balas</a>
                                </div>
                                <div class="reply-form-container d-none mb-3" style="margin-left: 40px;">
                                    <form action="{{ route('comment.balas') }}" method="POST"
                                        class="d-flex align-items-center w-100 reply-form" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                                        <input type="hidden" name="id_post" value="{{ $row->post_id }}">
                                        <input type="hidden" name="id_comment" value="{{ $row->id }}">
                                        <div class="input-group me-2" style="flex: 1;">
                                            {{-- <input type="text" name="comment" class="form-control"
                                                style="border-radius: 50px;" placeholder="Add Reply...." id="reply-input"> --}}
                                            <textarea name="comment" id="reply-input" class="form-control" style="border-radius: 50px;" rows="1"
                                                placeholder="Add Reply...." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm me-2"
                                            style="border-radius: 50px;">Send</button>
                                    </form>
                                </div>
                                @if (
                                    $countReplies === null ||
                                        collect($countReplies)->where('id_comment', $row->id)->isEmpty())
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
                                        <div class="replies-container" id="replies-{{ $row->id }}"
                                            style="display: none;">
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
                                                                            <img src="{{ asset('img/foto/' . $item->foto) }}"
                                                                                alt
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
                                                                        <span
                                                                            style="color: black;">{!! nl2br(e($item->comment)) !!}</span>
                                                                    </div>
                                                                </div>
                                                                {{-- <div>
                                                                    @if ($item->liked)
                                                                        <i class="fa fa-heart"
                                                                            style="color: red; cursor: pointer;"
                                                                            onclick="return likeReplies({{ $item->id }})"></i>
                                                                    @else
                                                                        <i class="fa fa-heart" style="cursor: pointer;"
                                                                            onclick="return likeReplies({{ $item->id }})"></i>
                                                                    @endif
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="d-inline-flex" style="margin-left: 78px;">
                                                            <p style="margin-right: 10px;">
                                                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                                            </p>
                                                            {{-- <p style="margin-right: 10px;">
                                                                {{ $item->likes }} suka</p> --}}
                                                            {{-- <a href="javascript:void(0);" class="reply-button2"
                                                                data-comment-id="{{ $item->comment_id }}"
                                                                data-reply-form-id="reply-form-{{ $item->comment_id }}"
                                                                style="margin-right: 10px; color: #818f9f;">Balas</a> --}}
                                                            {{-- <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#report{{ $row->id }}"><i
                                                                class="fa fa-ellipsis" style="color: #818f9f;"></i></a>
                                                        @include('modal.report') --}}
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
                                                class="w-px-30 h-auto rounded-circle lazyload"
                                                style="object-fit: cover;" />
                                        @endif
                                    </span>
                                    {{-- <input type="text" name="comment" class="form-control"
                                        style="border-radius: 50px;" placeholder="Add Comments...." id="komentar"> --}}
                                    <textarea name="comment" class="form-control" style="border-radius: 50px;" id="komentar" rows="1"
                                        placeholder="Add Comments...." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm me-2" id="sendForm"
                                    style="border-radius: 50px;">Send</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        function DeleteComment() {
            if (confirm('Hapus??')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    <script>
        function likeReplies(commentId) {
            event.preventDefault();
            console.log("Id Comment:", commentId);
            var scrollPosition = $(window).scrollTop();
            $.ajax({
                url: '/comment/likeReplies/' + commentId,
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
        function like(commentId) {
            // event.preventDefault();
            console.log("Id Comment:", commentId);
            var scrollPosition = $(window).scrollTop();
            $.ajax({
                url: '/comment/like/' + commentId,
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

            // Handle reply form submission
            $(document).on('submit', '.reply-form', function(e) {
                e.preventDefault();

                var form = $(this);
                var data = form.serialize();
                var scrollPosition = $(window).scrollTop();

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: data,
                    success: function(response) {
                        console.log('Reply submitted successfully:', response);
                        // Here you would typically update the UI to show the new reply
                        form.closest('.reply-form-container').addClass('d-none');
                        // Optionally, update the "View replies" link or add the new reply to the DOM
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error submitting reply:', error);
                    }
                });

                // Restore scroll position after the response
                $(window).scrollTop(scrollPosition);
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
@endpush
