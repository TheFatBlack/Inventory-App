<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ ($menu ?? '') == 'home' ? 'active' : '' }}">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('template/assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ ($menu ?? '') == 'admin' ? 'active' : '' }}">
                    <a href="{{route('admin.index')}}">
                        <img src="{{ asset('template/assets/img/icons/users1.svg') }}" alt="img">
                        <span>Admin</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>