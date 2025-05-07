<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="home">Bangjaki</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="home">BJ</a>
        </div>

        <ul class="sidebar-menu">
            {{-- <li class="menu-header">DashBoard</li> --}}
            <li class="nav-item dropdown">
                <a href="#"
                    class="has-dropdown">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('home') }}">General Dashboard</a>
                    </li>

                    {{-- <li class="{{ Request::is('dashboard-ecommerce-dashboard') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('dashboard-ecommerce-dashboard') }}">Ecommerce Dashboard</a>
                    </li> --}}
                </ul>
        </ul>

        <ul class="sidebar-menu">
            <li class="nav-item dropdown">
                <a href="home"
                    class="has-dropdown">
                    <i class="fas fa-fire"></i>
                    <span>Users</span>
                </a>
                <ul class="dropdown-menu">
                        <a class="submenu-item"
                            href="{{ route('users.index') }}">All users</a>
                            <ul class="dropdown-list ">
                                    {{-- membuat dropdown pelanggan --}}
                                <li>
                                    <a class="nav-link"
                                        href="#">Admin</a>
                                </li>
                                <li>
                                    <a class="nav-link"
                                        href="#">Pelanggan</a>
                                </li>
                            </ul>
                    </ul>
        </ul>
    </aside>
</div>
