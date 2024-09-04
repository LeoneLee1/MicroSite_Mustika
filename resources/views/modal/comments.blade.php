<!-- Modal -->
@foreach ($post as $item)
    <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                {{-- LAPTOP OR PC --}}
                <div class="modal-header d-none d-sm-block">
                    <h1 class="modal-title fs-5" style="margin-left: 210px;" id="exampleModalLabel">Comments</h1>
                </div>
                {{-- MOBILE --}}
                <div class="modal-header d-block d-sm-none">
                    <h1 class="modal-title fs-5" style="margin-left: 110px;" id="exampleModalLabel">Comments</h1>
                </div>
                <div class="modal-body">
                    @if (
                        $komen === null ||
                            collect($komen)->where('id_post', $item->id)->isEmpty())
                        <div class="text-center">
                            <h2>No Comments yet</h2>
                            <span>Start the conversation</span>
                        </div>
                    @else
                        @foreach ($komen as $row)
                            @if ($row->id_post == $item->id)
                                <div class="comment">
                                    <div class="text-left d-none d-sm-block">
                                        <strong>
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt class="w-px-50 h-auto rounded-circle lazyload" />
                                            &nbsp;{{ $row->nama }}
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
                                    <div class="text-left" style="margin-left: 20px;">
                                        <p>{!! nl2br(e($row->comment)) !!}</p>
                                    </div>
                                    <div class="text-left mb-3">
                                        <a href="#">Reply</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <form action="{{ route('comment.insert') }}" method="POST"
                        class="d-flex align-items-center w-100 comment-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                        <input type="hidden" name="id_post" value="{{ $item->id }}">
                        <div class="input-group me-2" style="flex: 1;">
                            <span class="input-group-text bg-white border-0 p-0" id="basic-addon1">
                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                    alt="User Avatar" class="w-px-50 h-auto rounded-circle lazyload"
                                    style="width: 50px; height: 50px; object-fit: cover;" />
                            </span>
                            <input type="text" name="comment" class="form-control" style="border-radius: 50px;"
                                placeholder="Add Comments....">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm me-2">Send</button>
                    </form>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@include('sweetalert::alert')

<script src="{{ asset('vendors/libs/jquery/jquery.js') }}"></script>
<script>
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
