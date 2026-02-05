<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ ($menu ?? '') == 'home' ? 'active' : '' }}">
                    <a href="{{ route('petugas.home') }}">
                        <img src="{{ asset('template/assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ ($menu ?? '') == 'petugas' ? 'active' : '' }}">
                    <a href="{{route('petugas.item.index')}}">
                        <img src="{{ asset('template/assets/img/icons/product.svg') }}" alt="img">
                        <span>item</span>
                    </a>
                </li>
                <li class="{{ ($menu ?? '') == 'item-category' ? 'active' : '' }}">
                    <a href="{{ route('petugas.item-category.index') }}">
                        <img src="{{ asset('template/assets/img/icons/product.svg') }}" alt="img">
                        <span>item category</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
