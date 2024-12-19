@include('modal.cariPost')
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand">
        <a href="/" class="app-brand-link mt-2">
            <img src="{{ asset('img/logo pendarasa.jpg') }}" alt="logo"
                style="max-width: 85px; height: auto; margin-left: 45px;">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1 mt-4">
        <!-- Dashboard -->
        <li
            class="menu-item {{ request()->is('beranda*') ? 'active' : '' }} {{ request()->is('comment*') ? 'active' : '' }} {{ request()->is('vote/view*') ? 'active' : '' }} {{ request()->is('viewNotification*') ? 'active' : '' }} mb-2">
            <a href="{{ route('beranda') }}" class="menu-link">
                <i class="menu-icon fa fa-home"></i>
                <div data-i18n="Analytics">Beranda</div>
            </a>
        </li>
        <li class="menu-item d-none d-sm-block mb-2">
            <a href="#" class="menu-link" data-bs-toggle="modal" data-bs-target="#searchPost">
                <i class="menu-icon fa fa-search"></i>
                <div data-i18n="Analytics">Cari</div>
            </a>
        </li>
        @if (Auth::user()->role === 'Admin' || Auth::user()->role === 'Anonymous')
            <li
                class="menu-item {{ request()->is('post*') ? 'active' : '' }} {{ request()->is('polling/create*') ? 'active' : '' }} mb-2">
                <a href="{{ route('post') }}" class="menu-link">
                    <i class="menu-icon fa fa-square-plus"></i>
                    <div data-i18n="Analytics">Buat</div>
                </a>
            </li>
        @endif
        <li class="menu-item {{ request()->is('analysis*') ? 'active' : '' }} mb-2">
            <a href="{{ route('analysis') }}" class="menu-link">
                <i class="menu-icon fa fa-chart-simple"></i>
                <div data-i18n="Analytics">Analysis</div>
            </a>
        </li>
        @if (Auth::user()->role === 'Admin')
            <li class="menu-item {{ request()->is('user*') ? 'active' : '' }} mb-2">
                <a href="{{ route('user') }}" class="menu-link">
                    <i class="menu-icon fa fa-users"></i>
                    <div data-i18n="Analytics">User</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('register/data*') ? 'active' : '' }} mb-2">
                <a href="{{ route('user.regis') }}" class="menu-link">
                    <i class="menu-icon fa fa-user-tag"></i>
                    <div data-i18n="Analytics">User Register</div>
                </a>
            </li>
        @endif
        <li
            class="menu-item {{ request()->is('profile*') ? 'active' : '' }} {{ request()->is('profile/edit*') ? 'active' : '' }} mb-2">
            <a href="{{ route('profile') }}" class="menu-link">
                <i class="menu-icon fa fa-user-pen"></i>
                <div data-i18n="Analytics">Profile & Akun</div>
            </a>
        </li>
        @if (Auth::user()->nik === 'daniel.it')
            <li class="menu-item {{ request()->is('admin/postingan*') ? 'active' : '' }} mb-2">
                <a href="{{ route('admin.postingan') }}" class="menu-link">
                    <i class="menu-icon fa fa-gear"></i>
                    <div data-i18n="Analytics">ADMIN</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
