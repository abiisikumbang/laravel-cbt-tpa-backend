<div class="main-sidebar sidebar-style-3">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img alt="image" src="{{ asset('img/stisla-fill.png') }}" class="square" width="90" height="60">
            <a href="home"></a>
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
            {{-- <div>
                <li class="{{ Request::is('users/create') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('users.create') }}">
                        <i class="fas fa-user-plus"></i>
                        <span>Add New User</span>
                    </a>
                </li>
                <li class="{{ Request::is('users/admin') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('users.index', ['role' => 'ADMIN'])}}">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin</span>
                    </a>
                </li>
                <li class="{{ Request::is('users/customer') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('users.index', ['role' => 'CUSTOMER'])}}">
                        <i class="fas fa-user-tag"></i>
                        <span>Customer</span>
                    </a>
                </li>
            </div> --}}
        </ul>
    </aside>
</div>
