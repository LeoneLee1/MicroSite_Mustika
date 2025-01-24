@extends('layout.app')

@section('title', 'Chat - Pendarrasa')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="chat-container">
            <div class="chat-card">
                <div class="chat-header">
                    <h5 class="mt-2" style="color: white;">User</h5>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('after-script')
@endpush
