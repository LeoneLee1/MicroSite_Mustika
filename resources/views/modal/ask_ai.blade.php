@foreach ($post as $item)
    <div class="modal fade" id="ai{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Hello,
                        {{ Auth::user()->nama }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center mb-4" style="color: black;">
                        Tanya Gemini AI untuk penjelasan terkait Kontent yang ingin anda tanyakan <i
                            class="fa fa-smile"></i>
                    </p>
                    <span style="color: black;">Silahkan pilih salah satu konten yang anda ingin tanyakan......</span>
                    <div class="mb-4"></div>
                    @php
                        $no = 1;
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Media</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($post_gambar as $row)
                                    @if ($row->id_post == $item->id)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                @if (strpos($row->media, '.mp4') !== false ||
                                                        strpos($row->media, '.webm') !== false ||
                                                        strpos($row->media, '.ogg') !== false)
                                                    <video controls class="img-fluid"
                                                        style="max-width: 30%; height: auto;">
                                                        <source src="{{ asset('media/' . $row->media) }}"
                                                            type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @elseif (strpos($row->media, 'youtube.com') !== false || strpos($row->media, 'youtu.be') !== false)
                                                    @php
                                                        preg_match(
                                                            '/(youtube\.com\/(watch\?v=|shorts\/)|youtu\.be\/)([^\&\?\/]+)/',
                                                            $row->media,
                                                            $matches,
                                                        );
                                                        $youtubeId = $matches[3] ?? null;
                                                    @endphp
                                                    @if ($youtubeId)
                                                        <div class="d-none d-sm-block">
                                                            <iframe
                                                                style="max-width: 300px; min-width: 300px; height: auto;"
                                                                src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen class="img-fluid lazyload"></iframe>
                                                        </div>
                                                        <div class="d-block d-sm-none">
                                                            <iframe
                                                                style="max-width: 300px; min-width: 300px; height: auto;"
                                                                src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen class="img-fluid lazyload"></iframe>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if ($row->media === null)
                                                    @else
                                                        <img src="{{ asset('media/' . $row->media) }}"
                                                            alt="media gambar" class="img-fluid lazyload"
                                                            style="height: 200px;">
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('analyze', $row->id) }}"
                                                    class="btn btn-sm btn-primary">Ask AI</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <i class="fa fa-info-circle" style="color: red;"></i>
                    <small style="color: red;">SEMUA JAWABAN MURNI DARI GEMINI AI!</small>
                </div>
            </div>
        </div>
    </div>
@endforeach
