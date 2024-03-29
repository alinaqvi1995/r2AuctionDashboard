<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light mx-n3">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="../dist/index.html">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120"
                    xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
                </svg>
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span><span class="sr-only">(current)</span>
                    {{-- <span class="badge badge-pill badge-primary">New</span> --}}
                </a>
            </li>
        </ul>
        {{-- <p class="text-muted nav-heading mt-4 mb-2 pl-4">
            <span>System Settings</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
                <a href="#ui-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-box fe-16"></i>
                    <span class="ml-3 item-text">Roles & Permissions</span>
                </a>
                <ul class="collapse list-unstyled w-100" id="ui-elements">
                    @if (auth()->user()->hasPermission('roles'))
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('roles.index') }}"><span
                                    class="ml-1 item-text">Roles</span></a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermission('permissions'))
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('permissions.index') }}"><span
                                    class="ml-1 item-text">Permissions</span></a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermission('role_permissions'))
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('role_permissions.index') }}"><span
                                    class="ml-1 item-text">RolesPermissions</span></a>
                        </li>
                    @endif
                </ul>
            </li>
        </ul> --}}
        {{-- <p class="text-muted nav-heading mt-4 mb-2 pl-4">
            <span>Category/Package</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
                <a href="#ui-category" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-box fe-16"></i>
                    <span class="ml-3 item-text">Categories</span>
                </a>
                <ul class="collapse list-unstyled w-100" id="ui-category">
                    @if (auth()->user()->hasPermission('categories'))
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('categories.index') }}"><span
                                    class="ml-1 item-text">Categories</span></a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermission('subcategories'))
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('subcategories.index') }}"><span
                                    class="ml-1 item-text">Subcategories</span></a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermission('packages'))
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('packages.index') }}"><span
                                    class="ml-1 item-text">Packages</span></a>
                        </li>
                    @endif
                </ul>
            </li>
        </ul> --}}
        @if (auth()->user()->hasPermission('products'))
            <p class="text-muted nav-heading mt-4 mb-2 pl-4">
                <span>Products</span>
            </p>
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100">
                    <a class="nav-link" href="{{ route('subVendor.products') }}">
                        <i class="fe fe-layers fe-16"></i>
                        <span class="ml-3 item-text">Products</span>
                        {{-- <span class="badge badge-pill badge-primary">New</span> --}}
                    </a>
                </li>
            </ul>
        @endif
        <p class="text-muted nav-heading mt-4 mb-2 pl-4">
            <span>Events</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
                <a href="#ui-events" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-layers fe-16"></i>
                    <span class="ml-3 item-text">Events</span>
                </a>
                <ul class="collapse list-unstyled w-100" id="ui-events">
                    @if (auth()->user()->hasPermission('events'))
                        <li class="nav-item @if (Route::is('subVendor.events')) active @endif">
                            <a class="nav-link" href="{{ route('subVendor.events') }}"><span
                                    class="ml-1 item-text">Events</span></a>
                        </li>
                    @endif
                    {{-- @if (auth()->user()->hasPermission('tickets'))
                        <li class="nav-item @if (Route::is('tickets.index')) active @endif">
                            <a class="nav-link" href="{{ route('tickets.index') }}">
                                Tickets Types
                            </a>
                        </li>
                    @endif --}}
                </ul>
            </li>
        </ul>

    </nav>
</aside>
