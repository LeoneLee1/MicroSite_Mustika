@extends('layout.app')

@section('title', 'Pendarasa - PT Mustika Jaya Lestari')

@section('navbar-item')
    <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-info"><i
            class="fa fa-arrow-left"></i>&nbsp;Back</a>
@endsection

@section('content')
    @foreach ($post as $item)
        @foreach ($poll as $p)
            @if ($p->id_post == $item->id)
                <div class="card">
                    <div class="card-body">
                        <h4 style="color: black; font-weight: bold; text-align: center;">{{ $p->soal }}</h4>
                        <div class="table-responsive-sm">
                            <table class="table table-bordered">
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
            @endif
        @endforeach
    @endforeach
@endsection
