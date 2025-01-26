<!-- Modal -->
<div class="modal fade" id="slideMediaEdit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (strpos($item->media, '.mp4') !== false ||
                        strpos($item->media, '.webm') !== false ||
                        strpos($item->media, '.ogg') !== false)
                    <video controls class="img-fluid" style="max-width: 50%; height: auto;">
                        <source src="{{ asset('media/' . $item->media) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @elseif (strpos($item->media, 'youtube.com') !== false || strpos($item->media, 'youtu.be') !== false)
                    @php
                        preg_match(
                            '/(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/)([^\&\?\/]+)/',
                            $item->media,
                            $matches,
                        );
                        $youtubeId = $matches[3] ?? null;
                    @endphp
                    @if ($youtubeId)
                        <div class="d-none d-sm-block">
                            <iframe style="width: 500px; height: 250px;"
                                src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen class="img-fluid lazyload"></iframe>
                        </div>
                        <div class="d-block d-sm-none">
                            <iframe style="max-width: 250px; min-width: 150px; height: 200px;"
                                src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen class="img-fluid lazyload"></iframe>
                        </div>
                    @endif
                @else
                    @if ($item->media === null)
                    @else
                        <a href="{{ asset('media/' . $item->media) }}">
                            <img src="{{ asset('media/' . $item->media) }}" alt="media gambar"
                                class="img-fluid lazyload" style="height: 300px;">
                        </a>
                    @endif
                @endif
                <div class="mt-4">
                    <form action="{{ route('post.slideUpdate', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label>
                                <input type="radio" name="input_type{{ $item->id }}"
                                    onclick="toggleInput({{ $item->id }}, 'text')" checked>
                                Isi Link
                            </label>
                            <label>
                                <input type="radio" name="input_type{{ $item->id }}"
                                    onclick="toggleInput({{ $item->id }}, 'file')">
                                Unggah File
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="media" id="text_input_div{{ $item->id }}"
                                placeholder="Link URL Youtube" class="form-control">
                            <input type="file" name="media" id="file_input_div{{ $item->id }}"
                                class="form-control" style="display: none;">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
