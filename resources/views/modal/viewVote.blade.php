<!-- Modal -->
<div class="modal fade" id="viewVote{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 style="color: black; font-weight: bold; text-align: center;">{{ $p->soal }}</h4>
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        {{-- @foreach ($jawabanModal as $a)
                            @if ($a->id_post == $item->id)
                                @if ($a->poll_id == $p->id)
                                    <thead>
                                        <tr>
                                            <th scope="col" style="color: black; font-weight: bold;">
                                                {{ $a->jawaban }}</th>
                                            <th scope="col" style="min-width: 200px; color:black;">
                                                {{ $a->value }}&nbsp;votes&nbsp;<i class="fa fa-star"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if ($a->nik_list === null || '')
                                            @else
                                                <td style="color: black;">{!! nl2br(e(str_replace(',', "\n\n", $a->nik_list))) !!}</td>
                                            @endif
                                            @if ($a->time_vote === null || '')
                                            @else
                                                <td style="color: black;">{!! nl2br(e(str_replace(',', "\n\n", $a->time_vote))) !!}</td>
                                        </tr>
                                @endif
                                </tbody>
                            @endif
                        @endif
                        @endforeach --}}
                        <thead>
                            <tr>
                                <th scope="col">Jawaban</th>
                                <th scope="col">Votes</th>
                                <th scope="col">Total Votes</th>
                                <th scope="col">Time Voting</th>
                            </tr>
                        </thead>
                        @foreach ($jawabanModal as $a)
                            @if ($a->id_post == $item->id)
                                @if ($a->poll_id == $p->id)
                                    <tbody>
                                        <tr>
                                            <td style="color: black;">{{ $a->jawaban }}</td>
                                            <td style="color: black;">{!! nl2br(e(str_replace(',', "\n\n", $a->nik_list ?? ''))) !!}</td>
                                            <td style="color: black;">{{ $a->value }}&nbsp;votes&nbsp;<i
                                                    class="fa fa-star"></i></td>
                                            <td style="color: black;">{!! nl2br(e(str_replace(',', "\n\n", $a->time_vote ?? ''))) !!}</td>
                                        </tr>
                                @endif
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
