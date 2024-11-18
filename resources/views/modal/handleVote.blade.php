<!-- Modal -->
<div class="modal fade" id="handleVote{{ $a->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $no = 1;
                @endphp
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NIK</th>
                            <th>JAWABAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($answer_vote as $item)
                            @if ($item->id_jawaban == $a->id)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->jawaban }}</td>
                                    <td>
                                        <a href="{{ route('vote.delete', $item->id) }}" class="btn btn-sm btn-primary"
                                            onclick="return konfirmasi()"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
