<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/logo.png') }}" alt="Pylon Auction Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Pylon Auction</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @if(request()->is('dashboard')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link @if(request()->is('categories*')) active @endif">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('products*')) menu-open @endif">
                    <a href="#" class="nav-link @if(request()->is('products*')) active @endif">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Products
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link @if(request()->is('products')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products.create') }}" class="nav-link @if(request()->is('products/create')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Product</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link @if(request()->is('orders*')) active @endif">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('pages*')) menu-open @endif">
                    <a href="#" class="nav-link @if(request()->is('pages*')) active @endif">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Pages
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('pages.index') }}" class="nav-link @if(request()->is('pages')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Pages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pages.create') }}" class="nav-link @if(request()->is('pages/create')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Page</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @if(request()->is('users*')) menu-open @endif">
                    <a href="#" class="nav-link @if(request()->is('users*')) active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link @if(request()->is('users')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="nav-link @if(request()->is('users/create')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>