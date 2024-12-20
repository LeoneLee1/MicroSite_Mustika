<!-- Modal -->
<div class="modal fade" id="viewMedia{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    @if (strpos($item->media, '.jpg') !== false ||
                            strpos($item->media, '.jpeg') !== false ||
                            strpos($item->media, '.png') !== false ||
                            strpos($item->media, 'data:image') !== false ||
                            strpos($item->media, '.gif') !== false)
                        <img src="{{ $item->media }}" alt="media gambar" class="img-fluid lazyload">
                    @elseif ($item->media_file !== null)
                        <img src="{{ asset('media/' . $item->media_file) }}" alt="media gambar"
                            class="img-fluid lazyload">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
