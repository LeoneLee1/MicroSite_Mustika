@extends('layout.app')

@section('title', 'Chat - Pendar rasa')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endpush

@section('content')
    <div class="text-center" id="loading" style="margin-top: 240px;">
        <div class="spinner-border spinner-border-lg text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="app-chat card overflow-hidden">
                <div class="row g-0">
                    <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end"
                        id="app-chat-contacts">
                        <div class="sidebar-header px-6 border-bottom d-flex align-items-center">
                            <div class="d-flex align-items-center me-6 me-lg-0">
                                <div class="flex-shrink-0 avatar avatar-online me-4" data-bs-toggle="sidebar"
                                    data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                                    @if (Auth::user()->foto == '' || null)
                                        <img class="user-avatar rounded-circle cursor-pointer"
                                            src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                            alt="Avatar">
                                    @else
                                        <img class="user-avatar rounded-circle cursor-pointer"
                                            src="{{ asset('img/foto/' . Auth::user()->foto) }}" alt="Avatar">
                                    @endif
                                </div>
                                <div class="flex-grow-1 input-group input-group-merge rounded-pill">
                                    <span class="input-group-text" id="basic-addon-search31"><i
                                            class="bx bx-search bx-sm"></i></span>
                                    <input type="text" class="form-control chat-search-input" placeholder="Search..."
                                        aria-label="Search..." aria-describedby="basic-addon-search31"
                                        fdprocessedid="dr7tt4">
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-body ps ps--active-y">
                            <ul class="list-unstyled chat-contact-list py-2 mb-0" id="chat-list">
                                <li class="chat-contact-list-item chat-contact-list-item-title mt-0">
                                    <h5 class="text-primary mb-0">Chats</h5>
                                </li>
                                <li class="chat-contact-list-item chat-list-item-0 d-none">
                                    <h6 class="text-muted mb-0">No Chats Found</h6>
                                </li>
                                <li class="chat-contact-list-item mb-2">
                                    <a class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar avatar-offline">
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div class="chat-contact-info flex-grow-1 ms-4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="chat-contact-name text-truncate fw-normal m-0">Felecia Rower
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <ul class="list-unstyled chat-contact-list mb-0 py-2" id="contact-list">
                                <li class="chat-contact-list-item chat-contact-list-item-title mt-0">
                                    <h5 class="text-primary mb-0">Contacts</h5>
                                </li>
                                <li class="chat-contact-list-item contact-list-item-0 d-none">
                                    <h6 class="text-muted mb-0">No Contacts Found</h6>
                                </li>
                                <li class="chat-contact-list-item">
                                    <a class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar">
                                            <img src="{{ url('https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg') }}"
                                                alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div class="chat-contact-info flex-grow-1 ms-4">
                                            <h6 class="chat-contact-name text-truncate m-0 fw-normal">Natalie Maxwell
                                            </h6>
                                            <small class="chat-contact-status text-truncate">Unit HO</small>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        const wait = (delay = 0) =>
            new Promise(resolve => setTimeout(resolve, delay));

        const setVisible = (elementOrSelector, visible) =>
            (typeof elementOrSelector === 'string' ?
                document.querySelector(elementOrSelector) :
                elementOrSelector
            ).style.display = visible ? 'block' : 'none';

        setVisible('.card', false);
        setVisible('#loading', true);

        document.addEventListener('DOMContentLoaded', () =>
            wait(1000).then(() => {
                setVisible('.card', true);
                setVisible('#loading', false);
            }));
    </script>
@endpush
