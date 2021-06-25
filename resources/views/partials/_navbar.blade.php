<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a href="#" class="user-panel" data-toggle="dropdown">
                <div class="image">
                @if($userimage = auth()->user()->image)
                    <img src="{{ filter_var($userimage, FILTER_VALIDATE_URL) ? $userimage : Storage::url($userimage) }}" class="img-circle elevation-2" alt="User Image" style="width:30px;height:30px;">
                @else
                    <img src="{{ asset('img/profile.png') }}" class="img-circle elevation-2" alt="User Image" style="width:30px;height:30px;">
                @endif
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('profile') }}" class="dropdown-item">
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('change-password') }}" class="dropdown-item">
                    Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" href="{{ route('logout') }}" title="{{ __('Logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
