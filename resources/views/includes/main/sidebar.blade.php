<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link mt-2">
            <img src="{{ asset('img/logo oval mustika.png') }}" alt="logo"
                style="max-width: 120px; min-width: 120px; margin-left: 25px;">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1 mt-4">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('/*') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon fa fa-home"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Data Master</span>
        </li>
        <li class="menu-item {{ request()->is('post*') ? 'active' : '' }} mb-3">
            <a href="{{ route('post') }}" class="menu-link">
                <i class="menu-icon fa fa-blog"></i>
                <div data-i18n="Analytics">Post</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('post*') ? 'active' : '' }} mb-3">
            <a href="{{ route('post') }}" class="menu-link">
                <i class="menu-icon fa fa-bars-progress"></i>
                <div data-i18n="Analytics">Polling</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('user*') ? 'active' : '' }} mb-3">
            <a href="{{ route('user') }}" class="menu-link">
                <i class="menu-icon fa fa-users"></i>
                <div data-i18n="Analytics">User</div>
            </a>
        </li>
    </ul>
</aside>
