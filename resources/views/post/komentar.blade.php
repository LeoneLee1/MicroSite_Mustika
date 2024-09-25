@extends('layout.app')

@section('title', 'Polling Web - PT Mustika Jaya Lestari')

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

@section('content')
    <div class="text-left mb-2">
        <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-info"><i
                class="fa fa-arrow-left"></i>&nbsp;Back</a>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="text-center" style="color: black; font-weight: bold; margin-bottom: 50px">{{ $post->judul }}</h4>
            @if (
                $komen === null ||
                    collect($komen)->where('id_post', $post->id)->isEmpty())
                <div class="text-center mb-4">
                    <h2>No Comments yet</h2>
                    <span>Start the conversation</span>
                </div>
            @endif
            @foreach ($komen as $row)
                <div class="comment">
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-left d-none d-sm-block">
                            <strong>
                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                    alt class="w-px-50 h-auto rounded-circle lazyload" />
                                &nbsp;{{ $row->nik }}
                            </strong>
                            &nbsp;&nbsp;• {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
                        </div>
                        <div class="text-left d-block d-sm-none">
                            <strong>
                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                    alt class="w-px-50 h-auto rounded-circle lazyload" />
                                &nbsp;{{ $row->nik }}
                            </strong>
                            &nbsp;&nbsp;• {{ \Carbon\Carbon::parse($row->created_at)->format('d M') }}
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-dark" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                @if ($row->nik == Auth::user()->nik)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('comment.delete', $row->id_comment) }}"
                                            onclick="return confirmDelete()"><i class="fa fa-trash menu-icon"
                                                style="color: red;"></i>&nbsp;Delete</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif
                                <li><a class="dropdown-item" href="#"><i class="fas fa-circle-exclamation"
                                            style="color: red;"></i>&nbsp;&nbsp;Report</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="text-left" style="margin-left: 20px;">
                        <p>{!! nl2br(e($row->comment)) !!}</p>
                    </div>
                    {{-- <div class="text-left mb-3">
                        <a href="#">Reply</a>
                    </div> --}}
                </div>
            @endforeach
            @if (!Auth::user()->role === 'Pengamat')
                <div class="d-flex justify-content-start">
                    <form action="{{ route('comment.insert') }}" method="POST"
                        class="d-flex align-items-center w-100 comment-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                        <input type="hidden" name="id_post" value="{{ $post->id }}">
                        <div class="input-group me-2" style="flex: 1;">
                            <span class="input-group-text bg-white border-0 p-0" id="basic-addon1">
                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                    alt="User Avatar" class="w-px-30 h-auto rounded-circle lazyload"
                                    style="width: 50px; height: 50px; object-fit: cover;" />
                            </span>
                            <input type="text" name="comment" class="form-control" style="border-radius: 50px;"
                                placeholder="Add Comments...." id="komentar">
                        </div>
                        {{-- <button type="submit" class="btn btn-primary btn-sm me-2" id="sendForm">Send</button> --}}
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('after-script')
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
