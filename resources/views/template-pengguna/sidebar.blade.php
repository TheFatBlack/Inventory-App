<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ ($menu ?? '') == 'home' ? 'active' : '' }}">
                    <a href="{{ route('pengguna.home') }}">
                        <img src="{{ asset('template/assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('pengguna.transaction.index') ? 'active' : '' }}">
                    <a href="{{ route('pengguna.transaction.index') }}">
                        <img src="{{ asset('template/assets/img/icons/transfer1.svg') }}" alt="img">
                        <span>Transaksi Barang</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('pengguna.transaction.create') ? 'active' : '' }}">
                    <a href="{{ route('pengguna.transaction.create') }}">
                        <img src="{{ asset('template/assets/img/icons/purchase1.svg') }}" alt="img">
                        <span>Tambah Transaksi</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
