<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0; /*  Height of navbar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Alows the sidebar to scroll if it has many items */
        }
        .nav-link.active {
            font-weight: bold;
            color: #fff !important;
        }
        main {
            padding-top: 1.5rem; /* Add some space at the top */
        }
    </style>
</head>
<body>
    <div id="app">
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="{{ route('admin.dashboard') }}">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </header>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Navigation -->
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.menu-items.*') ? 'active bg-primary' : '' }}" href="{{ route('admin.menu-items.index') }}"><i class="fas fa-utensils fa-fw me-2"></i> Menu Items</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active bg-primary' : '' }}" href="{{ route('admin.categories.index') }}"><i class="fas fa-folder-open fa-fw me-2"></i> Categories</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active bg-primary' : '' }}" href="{{ route('admin.tags.index') }}"><i class="fas fa-tags fa-fw me-2"></i> Tags & Allergens</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active bg-primary' : '' }}" href="{{ route('admin.reviews.index') }}"><i class="fas fa-comments fa-fw me-2"></i> Reviews</a></li>
                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase"><span>Tools & Settings</span></h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active bg-primary' : '' }}" href="{{ route('admin.settings.index') }}"><i class="fas fa-palette fa-fw me-2"></i> Branding</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.qrcode.show') ? 'active bg-primary' : '' }}" href="{{ route('admin.qrcode.show') }}"><i class="fas fa-qrcode fa-fw me-2"></i> QR Code</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('menu.index') }}" target="_blank"><i class="fas fa-eye fa-fw me-2"></i> View Live Menu</a></li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content Area -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>