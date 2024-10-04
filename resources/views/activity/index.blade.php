@extends('layout.app')

@section('title', 'Activity - PT Mustika Jaya Lestari')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h5 style="color: black; font-weight: bold;" class="card-header">View and manage your interactions, content
                and
                account activity.</h5>
            <div class="card-body">
                <div class="divider text-start">
                    <div class="divider-text">
                        <a href="{{ route('activity.likes') }}" class="btn btn-primary"><i
                                class="fa fa-heart"></i>&nbsp;&nbsp;Likes&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="divider text-start-center">
                    <div class="divider-text">
                        <a href="{{ route('activity.comments') }}" class="btn btn-primary"><i
                                class="fa fa-comment"></i>&nbsp;&nbsp;Comments&nbsp;&nbsp;<i
                                class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="divider">
                    <div class="divider-text">
                        <a href="{{ route('activity.posts') }}" class="btn btn-primary"><i
                                class="fa fa-border-all"></i>&nbsp;&nbsp;Posts&nbsp;&nbsp;<i
                                class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="divider text-end-center">
                    <div class="divider-text">
                        <a href="{{ route('activity.voting') }}" class="btn btn-primary"><i
                                class="fa fa-pie-chart"></i>&nbsp;&nbsp;Voting&nbsp;&nbsp;<i
                                class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        function confirmDelete() {
            if (confirm("Apakah kamu yakin ingin menghapus?")) {
                console.log("Delete confirmed!");
                return true;
            } else {
                console.log("Delete canceled!");
                return false;
            }
        }
    </script>
@endpush
