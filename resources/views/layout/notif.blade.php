<li class="nav-item lh-1 me-3 dropdown">
    <a href="#" role="button" class="dropdown-toggle hide-arrow position-relative" id="notification-dropdown"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell position-relative">
            @foreach ($notifBadge as $item)
                @if ($item->value == 0)
                @else
                    <span class="notification-badge">{{ $item->value }}</span>
                @endif
            @endforeach
        </i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-3" aria-labelledby="notification-dropdown">
        <li class="dropdown-header text-primary fw-bold">Notifications</li>
        @foreach ($notifPostLike as $row)
            @if (Auth::user()->nik == $row->nik_post)
                <li class="dropdown-item">
                    <a href="{{ route('post.lihat', $row->id_post) }}">
                        <div class="d-flex align-items-center">
                            @if (empty($row->foto))
                                <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                    alt="Default Image" class="w-px-30 me-2 h-auto rounded-circle lazyload" />
                            @else
                                <img src="{{ asset('img/foto/' . $row->foto) }}" alt="User Image"
                                    class="w-px-30 h-auto me-2 rounded-circle lazyload" />
                            @endif
                            <div class="text-truncate w-100">
                                <span class="d-block text-truncate"
                                    style="font-weight: bold; color:black;">{{ $row->nama }}</span>

                                <small class="d-block text-truncate"><i class="fa fa-heart"
                                        style="color: red;"></i>&nbsp;Menyukai
                                    Postingan Anda</small>
                                <div class="d-flex align-items-center text-muted small">
                                    {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endif
        @endforeach
        @foreach ($notifPostComment as $row)
            @if (Auth::user()->nik == $row->nik_post)
                <li class="dropdown-item">
                    <a href="{{ route('post.lihat', $row->id_post) }}">
                        <div class="d-flex align-items-center">
                            @if (empty($row->foto))
                                <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                    alt="Default Image" class="w-px-30 me-2 h-auto rounded-circle lazyload" />
                            @else
                                <img src="{{ asset('img/foto/' . $row->foto) }}" alt="User Image"
                                    class="w-px-30 h-auto me-2 rounded-circle lazyload" />
                            @endif
                            <div class="text-truncate w-100">
                                <span class="d-block text-truncate"
                                    style="font-weight: bold; color:black;">{{ $row->nama }}</span>

                                <small class="d-block text-truncate">Mengomentari Postingan
                                    Anda</small>
                                <div class="d-flex align-items-center text-muted small">
                                    {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endif
        @endforeach
        @foreach ($notifCommentLike as $row)
            @if (Auth::user()->nik == $row->nik_comment)
                <li class="dropdown-item">
                    <a href="{{ route('post.lihat', $row->id_post) }}">
                        <div class="d-flex align-items-center">
                            @if (empty($row->foto))
                                <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                    alt="Default Image" class="w-px-30 me-2 h-auto rounded-circle lazyload" />
                            @else
                                <img src="{{ asset('img/foto/' . $row->foto) }}" alt="User Image"
                                    class="w-px-30 h-auto me-2 rounded-circle lazyload" />
                            @endif
                            <div class="text-truncate w-100">
                                <span class="d-block text-truncate"
                                    style="font-weight: bold; color:black;">{{ $row->nama }}</span>
                                <small class="d-block text-truncate"><i class="fa fa-heart"
                                        style="color: red;"></i>&nbsp;Menyukai Komentar Anda</small>
                                <div class="d-flex align-items-center text-muted small">
                                    {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endif
        @endforeach
        @foreach ($notifCommentBalas as $row)
            @if (Auth::user()->nik == $row->nik_comment)
                <li class="dropdown-item">
                    <a href="{{ route('post.lihat', $row->id_post) }}">
                        <div class="d-flex align-items-center">
                            @if (empty($row->foto))
                                <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                    alt="Default Image" class="w-px-30 me-2 h-auto rounded-circle lazyload" />
                            @else
                                <img src="{{ asset('img/foto/' . $row->foto) }}" alt="User Image"
                                    class="w-px-30 h-auto me-2 rounded-circle lazyload" />
                            @endif
                            <div class="text-truncate w-100">
                                <span class="d-block text-truncate"
                                    style="font-weight: bold; color:black;">{{ $row->nama }}</span>

                                <small class="d-block text-truncate">Membalas Komentar Anda</small>
                                <div class="d-flex align-items-center text-muted small">
                                    {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endif
        @endforeach
        <li>
            <hr class="dropdown-divider">
        </li>
        <li class="text-center">
            <a href="{{ route('viewNotification') }}" class="text-primary fw-bold">View All
                Notifications</a>
        </li>
    </ul>
</li>
