<!-- Modal -->
@foreach ($post as $item)
    <div class="modal fade" id="menyukai{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 style="color: black; font-weight: bold; text-align: center;">Menyukai</h4>
                    @foreach ($postLike as $row)
                        @if ($row->id_post === $item->id)
                            <div class="d-flex flex-column bd-highlight mb-3">
                                <div class="p-2 bd-highlight">
                                    @if ($row->foto == null || '')
                                        <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                            alt class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;
                                    @else
                                        <img src="{{ asset('img/foto/' . $row->foto) }}" alt
                                            class="w-px-40 h-auto rounded-circle lazyload" />&nbsp;&nbsp;
                                    @endif
                                    <span style="color: black; font-weight: bold;">{{ $row->nama }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach
