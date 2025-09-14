<div class="main-sidebar sidebar-style-3">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('home') }}">
                <img alt="image" src="{{ asset('img/stisla-fill.png') }}" class="square" width="90" height="60">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm ml-2 mt-6">
            <a href="{{ url('home') }}">
                <img alt="image" src="{{ asset('img/logo_bangjAKI.svg') }}" class="square" width="50"
                    height="50">
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('home') }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li class="menu-header">Transaksi</li>
            <li class="{{ Request::is('transactions') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('transactions.index') }}">
                    <i class="fas fa-table"></i>
                    <span>Tabel Transaksi</span>
                </a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('redeem') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('redeem.index') }}">
                    <i class="fas fa-gift"></i>
                    <span>Tabel Transaksi Redeem</span>
                </a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li class="menu-header">Data Admin</li>
            <li class="{{ Request::is('users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Tabel User</span>
                </a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('wastes') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('wastes.index') }}">
                    <i class="fas fa-recycle"></i>
                    <span>Tabel Sampah</span>
                </a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('stocks') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('stocks.index') }}">
                    <i class="fas fa-boxes"></i>
                    <span>Tabel Reward</span>
                </a>
            </li>
        </ul>

    </aside>
</div>
