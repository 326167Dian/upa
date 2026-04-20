<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? 'Dashboard' }}</title>

    @php
        $espireBase = 'Espire/espireadmin-10/Espire - Bootstrap Admin Template/html/demo/app';
        $espireAsset = fn (string $path) => url(str_replace('%2F', '/', rawurlencode($espireBase.'/assets/'.$path)));
    @endphp

    <link rel="shortcut icon" href="{{ $espireAsset('images/logo/favicon.ico') }}">
    <link href="{{ $espireAsset('vendors/apexcharts/dist/apexcharts.css') }}" rel="stylesheet">
    <link href="{{ $espireAsset('css/app.min.css') }}" rel="stylesheet">
    <style>
        .content-shell {
            min-height: 100vh;
            background: #edf4f9;
        }

        .desktop-alert {
            padding-bottom: 0;
        }

        .operator-toolbar .btn + .btn {
            margin-left: 0.5rem;
        }

        @media only screen and (min-width: 992px) {
            .side-nav.auto-hide-ready {
                transition: width 0.2s ease;
            }

            .content-shell .main {
                padding: 1.5625rem;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <div class="vertical-layout">
            <div class="header-text-dark header-nav layout-vertical is-collapse" id="app-header">
                <div class="header-nav-wrap">
                    <div class="header-nav-left">
                        <div class="header-nav-item desktop-toggle">
                            <div class="header-nav-item-select cursor-pointer">
                                <i class="nav-icon feather icon-menu icon-arrow-right"></i>
                            </div>
                        </div>
                        <div class="header-nav-item mobile-toggle">
                            <div class="header-nav-item-select cursor-pointer">
                                <i class="nav-icon feather icon-menu icon-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    <div class="header-nav-right">
                        <div class="header-nav-item">
                            <div class="dropdown header-nav-item-select nav-profile">
                                <div class="toggle-wrapper" id="nav-profile-dropdown" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-circle avatar-image" style="width: 35px; height: 35px; line-height: 35px;">
                                        <img src="{{ $espireAsset('images/avatars/thumb-1.jpg') }}" alt="avatar">
                                    </div>
                                    <span class="fw-bold mx-1">{{ auth()->user()->username }}</span>
                                    <i class="feather icon-chevron-down"></i>
                                </div>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="nav-profile-header">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-circle avatar-image">
                                                <img src="{{ $espireAsset('images/avatars/thumb-1.jpg') }}" alt="avatar">
                                            </div>
                                            <div class="d-flex flex-column ms-1">
                                                <span class="fw-bold text-dark">{{ auth()->user()->name }}</span>
                                                <span class="font-size-sm text-uppercase">{{ auth()->user()->role }}</span>
                                                <span class="font-size-sm">{{ auth()->user()->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item border-0 bg-transparent w-100 text-start">
                                            <div class="d-flex align-items-center">
                                                <i class="font-size-lg me-2 feather icon-power"></i>
                                                <span>Sign Out</span>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="side-nav vertical-menu nav-menu-light scrollable nav-menu-collapse auto-hide-ready" id="app-sidebar">
                <div class="nav-logo">
                    <div class="w-100 logo">
                        <img class="img-fluid" src="{{ $espireAsset('images/logo/logo.png') }}" style="max-height: 70px;" alt="logo">
                    </div>
                    <div class="mobile-close">
                        <i class="icon-arrow-left feather"></i>
                    </div>
                </div>
                <ul class="nav-menu">
                    <li class="nav-menu-item {{ request()->routeIs('dashboard') ? 'router-link-active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="feather icon-home"></i>
                            <span class="nav-menu-item-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-menu-item {{ request()->routeIs('operators.*') ? 'router-link-active' : '' }}">
                        <a href="{{ route('operators.index') }}">
                            <i class="feather icon-users"></i>
                            <span class="nav-menu-item-title">Operator</span>
                        </a>
                    </li>
                    <li class="nav-menu-item {{ request()->routeIs('kegiatan.*') ? 'router-link-active' : '' }}">
                        <a href="{{ route('kegiatan.index') }}">
                            <i class="feather icon-clipboard"></i>
                            <span class="nav-menu-item-title">Kegiatan</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="content is-collapse content-shell" id="app-content">
                @if (session('success'))
                    <div class="main desktop-alert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="main desktop-alert">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ $espireAsset('js/vendors.min.js') }}"></script>
    <script src="{{ $espireAsset('js/app.min.js') }}"></script>
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('app-sidebar');
            const header = document.getElementById('app-header');
            const content = document.getElementById('app-content');
            const desktopQuery = window.matchMedia('(min-width: 992px)');

            if (!sidebar || !header || !content) {
                return;
            }

            const collapseDesktopNav = function () {
                if (!desktopQuery.matches) {
                    sidebar.classList.remove('nav-menu-collapse');
                    header.classList.remove('is-collapse');
                    content.classList.remove('is-collapse');
                    return;
                }

                sidebar.classList.add('nav-menu-collapse');
                header.classList.add('is-collapse');
                content.classList.add('is-collapse');
            };

            const expandDesktopNav = function () {
                if (!desktopQuery.matches) {
                    return;
                }

                sidebar.classList.remove('nav-menu-collapse');
                header.classList.remove('is-collapse');
                content.classList.remove('is-collapse');
            };

            collapseDesktopNav();

            sidebar.addEventListener('mouseenter', expandDesktopNav);
            sidebar.addEventListener('mouseleave', collapseDesktopNav);
            sidebar.addEventListener('focusin', expandDesktopNav);

            document.addEventListener('click', function (event) {
                if (!desktopQuery.matches) {
                    return;
                }

                if (!sidebar.contains(event.target)) {
                    collapseDesktopNav();
                }
            });

            if (typeof desktopQuery.addEventListener === 'function') {
                desktopQuery.addEventListener('change', collapseDesktopNav);
            } else if (typeof desktopQuery.addListener === 'function') {
                desktopQuery.addListener(collapseDesktopNav);
            }
        });
    </script>
</body>
</html>