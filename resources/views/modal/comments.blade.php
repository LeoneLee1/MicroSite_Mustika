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
                                    <div class="text-left">
                                        <strong>
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt class="w-px-50 h-auto rounded-circle lazyload" />
                                            &nbsp;{{ $row->nama }}
                                        </strong>
                                        &nbsp;&nbsp;• {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
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
                    <form method="POST" id="commentForm" class="d-flex align-items-center w-100">
                        @csrf
                        <input type="hidden" name="nik" value="{{ Auth::user()->nik }}" id="nik">
                        <input type="hidden" name="id_post" value="{{ $item->id }}" id="id_post">
                        <div class="input-group me-2" style="flex: 1;">
                            <span class="input-group-text bg-white border-0 p-0" id="basic-addon1">
                                <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                    alt="User Avatar" class="w-px-50 h-auto rounded-circle lazyload"
                                    style="width: 50px; height: 50px; object-fit: cover;" />
                            </span>
                            <input type="text" name="comment" class="form-control" style="border-radius: 50px;"
                                id="comment" placeholder="Add Comments....">
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

<script src="{{ asset('js/sweetalert.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#commentForm').on('submit', function(e) {
            e.preventDefault();
            console.log('awdawd');

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('comment') }}',
                type: $(this).attr('method'),
                data: formData,
                // processData: false,
                // contentType: false,
                success: function(response) {
                    console.log(response);

                    // Asumsikan response adalah JSON yang berisi pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Komentar berhasil ditambahkan',
                        confirmButtonText: 'Ok'
                    });

                    // Optionally, update the comments section without refreshing the page
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.responseText ||
                            'Komentar gagal ditambahkan. Silakan coba lagi.',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });
    });
</script>
