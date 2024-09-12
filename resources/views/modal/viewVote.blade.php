<!-- Modal -->
<div class="modal fade" id="viewVote{{ $questionId }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <h4 style="color: black; font-weight: bold; text-align: center;">{{ $question }}</h4>
                    <div class="table-responsive-sm">
                        <table class="table table-bordered">
                            @foreach ($answers as $answer)
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align: left;">{{ $answer->jawaban }}</th>
                                        @if ($answer->voted === null)
                                            <th scope="col" style="text-align: left;">0&nbsp;votes&nbsp;<i
                                                    class="fa fa-star"></i></th>
                                        @else
                                            <th scope="col" style="text-align: left;">
                                                {{ $answer->value }}&nbsp;votes&nbsp;<i class="fa fa-star"></i>
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @if ($answer->voted === null)
                                        @else
                                            <td style="text-align: left;"><img
                                                    src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                    alt="User Avatar" class="w-px-40 h-auto rounded-circle lazyload"
                                                    style="object-fit: cover;" />&nbsp;{{ $answer->voted }}</td>
                                        @endif
                                        @if ($answer->time_vote === null)
                                        @else
                                            <td scope="col" style="text-align: left;">
                                                {{ date('d/m/Y H:i', strtotime($answer->time_vote)) }}
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
