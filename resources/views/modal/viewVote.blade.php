<!-- Modal -->
<div class="modal fade" id="viewVote{{ $questionId }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $question }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    @foreach ($answers as $answer)
                        <h5>{{ $answer->jawaban }}</h5>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
