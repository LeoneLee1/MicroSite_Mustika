@extends('layout.app')

@section('title', 'Polling Web - PT Mustika Jaya Lestari')

@section('content')
    <div class="text-left mb-2">
        <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-info"><i
                class="fa fa-arrow-left"></i>&nbsp;Back</a>
    </div>
    <div class="card">
        <div class="card-body">
            @php
                $soal = $votesCollection->first()->soal;
            @endphp
            <h4 class="text-center" style="color: black; font-weight: bold;">{{ $soal }}</h4>
            <div class="table-responsive-sm">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" style="color: black; min-width: 0px;">Jawaban</th>
                            <th scope="col" style="color: black;">Total Votes</th>
                            <th scope="col" style="color: black;">Voters</th>
                            <th scope="col" style="color: black; min-width: 200px;">Voting Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($votesCollection as $item)
                            <tr>
                                <td style="color: black;">{{ $item->jawaban }}</td>
                                <td style="color: black;">
                                    {{ $item->total_votes ?? '0' }} votes&nbsp;<i class="fa fa-star"></i>
                                </td>
                                <td style="color: black;">
                                    {!! nl2br(e(str_replace(',', "\n\n", $item->votes ?? ''))) !!}
                                </td>
                                <td style="color: black;">
                                    {!! nl2br(e(str_replace(',', "\n\n", $item->time_votes ?? ''))) !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
