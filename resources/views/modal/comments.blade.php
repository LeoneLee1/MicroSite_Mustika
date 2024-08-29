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
                <div class="modal-body" id="commentsList{{ $item->id }}">
                    @if ($komen == null)
                        <div class="text-center">
                            <h2>No Comments yet</h2>
                            <span>Start the conversation</span>
                        </div>
                    @else
                        @foreach ($komen as $row)
                            <div class="comment" data-id="{{ $row->id }}">
                                <div class="text-left">
                                    <strong><img
                                            src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                            alt
                                            class="w-px-50 h-auto rounded-circle" />&nbsp;{{ $row->nama }}</strong>&nbsp;&nbsp;•
                                    {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
                                </div>
                                <div class="text-left" style="margin-left: 20px;">
                                    <p>{!! nl2br(e($row->comment)) !!}</p>
                                </div>
                                <div class="text-left mb-3">
                                    <a href="#">Reply</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    @foreach ($post as $p)
                        <form action="{{ route('comment') }}" method="POST" enctype="multipart/form-data"
                            class="d-flex align-items-center w-100">
                            @csrf
                            <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">
                            <input type="hidden" name="id_post" value="{{ $p->id }}">
                            <div class="input-group me-2" style="flex: 1;">
                                <span class="input-group-text bg-white border-0 p-0" id="basic-addon1">
                                    <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                        alt="User Avatar" class="w-px-50 h-auto rounded-circle"
                                        style="width: 50px; height: 50px; object-fit: cover;" />
                                </span>
                                <input type="text" name="comment" class="form-control" style="border-radius: 50px;"
                                    placeholder="Add Comments....">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm me-2">Send</button>
                        </form>
                    @endforeach
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
