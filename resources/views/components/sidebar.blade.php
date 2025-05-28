<div class="main-sidebar sidebar-style-3">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('home') }}">
                <img alt="image" src="{{ asset('img/stisla-fill.png') }}" class="square" width="90" height="60">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm ml-2">
            <a href="{{ url('home') }}">
                <img alt="image" src="{{ asset('img/logo_bangjAKI.svg') }}" class="square" width="50"
                    height="50">
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('home') }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>All Users</span>
                </a>
            </li>

        </ul>
    </aside>
</div>
