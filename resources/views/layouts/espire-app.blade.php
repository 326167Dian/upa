<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ckeditor-upload-url" content="{{ route('pengumuman.upload-image') }}">
    <title>{{ $title ?? 'Dashboard' }}</title>

    @php
        $espireBase = 'Espire/espireadmin-10/Espire - Bootstrap Admin Template/html/demo/app';
        $espireAsset = fn (string $path) => url(str_replace('%2F', '/', rawurlencode($espireBase.'/assets/'.$path)));
    @endphp

    <link rel="shortcut icon" href="{{ $espireAsset('images/logo/favicon.ico') }}">
    <link href="{{ $espireAsset('vendors/apexcharts/dist/apexcharts.css') }}" rel="stylesheet">
    <link href="{{ $espireAsset('css/app.min.css') }}" rel="stylesheet">
    <style>
        .vertical-layout {
            position: relative;
        }

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

        .wysiwyg-preview {
            min-width: 260px;
            max-width: 520px;
            white-space: normal;
            line-height: 1.6;
            color: #455560;
        }

        .wysiwyg-preview p,
        .wysiwyg-preview ul,
        .wysiwyg-preview ol {
            margin-bottom: 0.5rem;
        }

        .wysiwyg-preview p:last-child,
        .wysiwyg-preview ul:last-child,
        .wysiwyg-preview ol:last-child {
            margin-bottom: 0;
        }

        .wysiwyg-preview ul,
        .wysiwyg-preview ol {
            padding-left: 1.25rem;
        }

        .desktop-sidebar-toggle {
            display: none;
        }

        .side-nav .logo .sidebar-brand {
            display: block;
            width: auto;
            max-width: 100%;
            max-height: 64px;
            margin: 0 auto;
            object-fit: contain;
        }

        @media only screen and (min-width: 992px) {
            .vertical-layout {
                --desktop-sidebar-width: 250px;
            }

            .content-shell .main {
                padding: 1.5625rem;
            }

            .side-nav.auto-hide-ready {
                width: var(--desktop-sidebar-width);
                transition: width 0.3s ease, box-shadow 0.3s ease;
                overflow: hidden;
            }

            #app-header,
            #app-content {
                transition: all 0.3s ease;
            }

            .desktop-sidebar-toggle {
                position: fixed;
                top: 50%;
                left: calc(var(--desktop-sidebar-width) - 1px);
                transform: translateY(-50%);
                z-index: 1100;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 28px;
                height: 72px;
                padding: 0;
                border: 1px solid #d7e2ec;
                border-left: 0;
                border-radius: 0 14px 14px 0;
                background: #ffffff;
                color: #4a5a6a;
                box-shadow: 10px 0 30px rgba(16, 24, 40, 0.08);
                cursor: pointer;
                transition: left 0.3s ease, background-color 0.2s ease, color 0.2s ease;
            }

            .desktop-sidebar-toggle:hover {
                background: #f3f7fb;
                color: #1f6feb;
            }

            .desktop-sidebar-toggle span {
                font-size: 1rem;
                line-height: 1;
            }

            body.sidebar-collapsed #app-sidebar {
                width: 0 !important;
                box-shadow: none;
            }

            body.sidebar-collapsed #app-header,
            body.sidebar-collapsed #app-content {
                left: 0 !important;
                width: 100% !important;
                margin-left: 0 !important;
            }

            body.sidebar-collapsed .desktop-sidebar-toggle {
                left: 0;
            }
        }

        @media only screen and (max-width: 991.98px) {
            .desktop-sidebar-toggle {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <div class="vertical-layout">
            <div class="header-text-dark header-nav layout-vertical" id="app-header">
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
                                        <img src="{{ asset('images/cakep.png') }}" alt="avatar">
                                    </div>
                                    <span class="fw-bold mx-1">{{ auth()->user()->username }}</span>
                                    <i class="feather icon-chevron-down"></i>
                                </div>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="nav-profile-header">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-circle avatar-image">
                                                <img src="{{ asset('images/cakep.png') }}" alt="avatar">
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

            <div class="side-nav vertical-menu nav-menu-light scrollable auto-hide-ready" id="app-sidebar">
                <div class="nav-logo">
                    <div class="w-100 logo">
                        <img class="img-fluid sidebar-brand" src="{{ asset('logo.png') }}" alt="Logo UPA">
                    </div>
                    <div class="mobile-close">
                        <i class="icon-arrow-left feather"></i>
                    </div>
                </div>
                <ul class="nav-menu">
                    @if (auth()->user()->hasFeatureAccess('dashboard.view'))
                        <li class="nav-menu-item {{ request()->routeIs('dashboard') ? 'router-link-active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <i class="feather icon-home"></i>
                                <span class="nav-menu-item-title">Dashboard</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasFeatureAccess('operators.view'))
                        <li class="nav-menu-item {{ request()->routeIs('operators.*') ? 'router-link-active' : '' }}">
                            <a href="{{ route('operators.index') }}">
                                <i class="feather icon-users"></i>
                                <span class="nav-menu-item-title">Operator</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasFeatureAccess('kegiatan.view'))
                        <li class="nav-menu-item {{ request()->routeIs('kegiatan.*') ? 'router-link-active' : '' }}">
                            <a href="{{ route('kegiatan.index') }}">
                                <i class="feather icon-clipboard"></i>
                                <span class="nav-menu-item-title">Kegiatan</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasFeatureAccess('kehadiran.view'))
                        <li class="nav-menu-item {{ request()->routeIs('kehadiran.*') ? 'router-link-active' : '' }}">
                            <a href="{{ route('kehadiran.index') }}">
                                <i class="feather icon-check-square"></i>
                                <span class="nav-menu-item-title">Kehadiran</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasFeatureAccess('jurnal_kas.view'))
                        <li class="nav-menu-item {{ request()->routeIs('jurnal-kas.*') ? 'router-link-active' : '' }}">
                            <a href="{{ route('jurnal-kas.index') }}">
                                <i class="feather icon-book-open"></i>
                                <span class="nav-menu-item-title">Jurnal Kas</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasFeatureAccess('pengumuman.view'))
                        <li class="nav-menu-item {{ request()->routeIs('pengumuman.*') ? 'router-link-active' : '' }}">
                            <a href="{{ route('pengumuman.index') }}">
                                <i class="feather icon-volume-2"></i>
                                <span class="nav-menu-item-title">Pengumuman</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <button id="sidebar-toggle-btn" class="desktop-sidebar-toggle" type="button" aria-label="Ciutkan sidebar" aria-expanded="true">
                <span id="sidebar-toggle-arrow">&#9664;</span>
            </button>

            <div class="content content-shell" id="app-content">
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
            const toggleButton = document.getElementById('sidebar-toggle-btn');
            const toggleArrow = document.getElementById('sidebar-toggle-arrow');
            const desktopToggle = document.querySelector('#app-header .desktop-toggle');
            const desktopQuery = window.matchMedia('(min-width: 992px)');
            const storageKey = 'upa-sidebar-collapsed';

            if (!sidebar || !header || !content || !toggleButton || !toggleArrow) {
                return;
            }

            const setDesktopSidebarState = function (collapsed, persistState = true) {
                if (!desktopQuery.matches) {
                    document.body.classList.remove('sidebar-collapsed');
                    sidebar.classList.remove('nav-menu-collapse');
                    header.classList.remove('is-collapse');
                    content.classList.remove('is-collapse');
                    toggleArrow.innerHTML = '&#9664;';
                    toggleButton.setAttribute('aria-expanded', 'true');
                    toggleButton.setAttribute('aria-label', 'Ciutkan sidebar');

                    return;
                }

                document.body.classList.toggle('sidebar-collapsed', collapsed);
                sidebar.classList.toggle('nav-menu-collapse', collapsed);
                header.classList.toggle('is-collapse', collapsed);
                content.classList.toggle('is-collapse', collapsed);
                toggleArrow.innerHTML = collapsed ? '&#9654;' : '&#9664;';
                toggleButton.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
                toggleButton.setAttribute('aria-label', collapsed ? 'Buka sidebar' : 'Ciutkan sidebar');

                if (persistState) {
                    window.localStorage.setItem(storageKey, collapsed ? '1' : '0');
                }
            };

            const syncDesktopSidebar = function () {
                const collapsed = window.localStorage.getItem(storageKey) === '1';

                setDesktopSidebarState(collapsed, false);
            };

            syncDesktopSidebar();

            toggleButton.addEventListener('click', function () {
                setDesktopSidebarState(!document.body.classList.contains('sidebar-collapsed'));
            });

            desktopToggle?.addEventListener('click', function () {
                if (!desktopQuery.matches) {
                    return;
                }

                setDesktopSidebarState(!document.body.classList.contains('sidebar-collapsed'));
            });

            if (typeof desktopQuery.addEventListener === 'function') {
                desktopQuery.addEventListener('change', syncDesktopSidebar);
            } else if (typeof desktopQuery.addListener === 'function') {
                desktopQuery.addListener(syncDesktopSidebar);
            }
        });
    </script>
</body>
</html>