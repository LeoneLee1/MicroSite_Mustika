<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand">
        <a href="/" class="app-brand-link mt-2">
            <img src="{{ asset('img/logo pendarasa.jpg') }}" alt="logo"
                style="max-width: 100px; height: auto; margin-left: 45px;">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1 mt-4">
        <!-- Dashboard -->
        <li
            class="menu-item {{ request()->is('/*') ? 'active' : '' }} {{ request()->is('comment*') ? 'active' : '' }} {{ request()->is('vote/view*') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon fa fa-home"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @if (Auth::user()->role === 'User' || Auth::user()->role === 'Admin')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Data Master</span>
            </li>
            <li
                class="menu-item {{ request()->is('post*') ? 'active' : '' }} {{ request()->is('polling/create*') ? 'active' : '' }} mb-3">
                <a href="{{ route('post') }}" class="menu-link">
                    <i class="menu-icon fa fa-square-plus"></i>
                    <div data-i18n="Analytics">Post</div>
                </a>
            </li>
        @endif
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Settings</span>
        </li>
        <li class="menu-item {{ request()->is('analysis*') ? 'active' : '' }} mb-3">
            <a href="{{ route('analysis') }}" class="menu-link">
                <i class="menu-icon fa fa-chart-simple"></i>
                <div data-i18n="Analytics">Analysis</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('activity*') ? 'active' : '' }} mb-3">
            <a href="{{ route('activity') }}" class="menu-link">
                <i class="menu-icon fa fa-chart-line"></i>
                <div data-i18n="Analytics">Your activity</div>
            </a>
        </li>
        @if (Auth::user()->role === 'Admin')
            <li class="menu-item {{ request()->is('user*') ? 'active' : '' }} mb-3">
                <a href="{{ route('user') }}" class="menu-link">
                    <i class="menu-icon fa fa-users"></i>
                    <div data-i18n="Analytics">User</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('register/data*') ? 'active' : '' }} mb-3">
                <a href="{{ route('user.regis') }}" class="menu-link">
                    <i class="menu-icon fa fa-user-tag"></i>
                    <div data-i18n="Analytics">User Register</div>
                </a>
            </li>
        @endif
        <li
            class="menu-item {{ request()->is('profile*') ? 'active' : '' }} {{ request()->is('profile/edit*') ? 'active' : '' }} mb-3">
            <a href="{{ route('profile') }}" class="menu-link">
                <i class="menu-icon fa fa-user-pen"></i>
                <div data-i18n="Analytics">Profile & Akun</div>
            </a>
        </li>
    </ul>
</aside>
