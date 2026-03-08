<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'FrozenBytes Admin' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @livewireStyles
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 78px;
            --header-height: 68px;
            --footer-height: 50px;
        }

        .admin-shell {
            overflow-x: hidden;
        }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            z-index: 1040;
            transition: transform .25s ease;
        }

        .admin-content {
            margin-left: var(--sidebar-width);
            transition: margin-left .25s ease;
            min-height: 100vh;
        }

        .admin-header {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--header-height);
            z-index: 1030;
            transition: left .25s ease;
        }

        .admin-footer {
            position: fixed;
            right: 0;
            left: var(--sidebar-width);
            bottom: 0;
            height: var(--footer-height);
            z-index: 1030;
            transition: left .25s ease;
        }

        .admin-main {
            padding: calc(var(--header-height) + 1rem) 1.5rem calc(var(--footer-height) + 1rem);
        }

        .admin-brand-logo {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 999px;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            flex: 0 0 20px;
        }

        .admin-shell.sidebar-collapsed .admin-sidebar {
            width: var(--sidebar-collapsed-width);
        }

        .admin-shell.sidebar-collapsed .admin-brand-text,
        .admin-shell.sidebar-collapsed .nav-label {
            display: none;
        }

        .admin-shell.sidebar-collapsed .admin-brand {
            justify-content: center;
        }

        .admin-shell.sidebar-collapsed .admin-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        .admin-shell.sidebar-collapsed .admin-header,
        .admin-shell.sidebar-collapsed .admin-footer {
            left: var(--sidebar-collapsed-width);
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
                box-shadow: 0 0 0 9999px rgba(0, 0, 0, .35);
                width: var(--sidebar-width);
            }

            .admin-shell.sidebar-open .admin-sidebar {
                transform: translateX(0);
            }

            .admin-content {
                margin-left: 0;
            }

            .admin-header,
            .admin-footer {
                left: 0;
            }

            .admin-shell.sidebar-collapsed .admin-brand-text,
            .admin-shell.sidebar-collapsed .nav-label {
                display: inline;
            }
        }
    </style>
</head>

<body class="bg-light admin-shell" id="adminShell">
    @php
        $siteSetting = \App\Models\SiteSetting::current();
        $adminLogo = $siteSetting->logoAssetUrl();
    @endphp
    <aside class="admin-sidebar bg-dark text-white p-3">
        <div class="admin-brand d-flex align-items-center gap-2 mb-4">
            @if ($adminLogo)
                <img src="{{ $adminLogo }}" alt="logo" class="admin-brand-logo">
            @else
                <span class="admin-brand-logo d-inline-flex align-items-center justify-content-center bg-primary text-white fw-semibold">F</span>
            @endif
            <h5 class="mb-0 admin-brand-text">{{ $siteSetting->business_name }}</h5>
        </div>
        <ul class="nav nav-pills flex-column gap-2">
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.dashboard')) active @else text-white @endif"
                    href="{{ route('app.dashboard') }}"><span class="nav-item-link"><i class="bi bi-speedometer2 nav-icon"></i><span class="nav-label">Dashboard</span></span></a></li>
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.pages')) active @else text-white @endif"
                    href="{{ route('app.pages') }}"><span class="nav-item-link"><i class="bi bi-file-earmark-text nav-icon"></i><span class="nav-label">Pages</span></span></a></li>
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.services')) active @else text-white @endif"
                    href="{{ route('app.services') }}"><span class="nav-item-link"><i class="bi bi-briefcase nav-icon"></i><span class="nav-label">Services</span></span></a></li>
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.projects')) active @else text-white @endif"
                    href="{{ route('app.projects') }}"><span class="nav-item-link"><i class="bi bi-kanban nav-icon"></i><span class="nav-label">Projects</span></span></a></li>
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.blog')) active @else text-white @endif"
                    href="{{ route('app.blog') }}"><span class="nav-item-link"><i class="bi bi-journal-text nav-icon"></i><span class="nav-label">Blog</span></span></a></li>
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.reviews')) active @else text-white @endif"
                    href="{{ route('app.reviews') }}"><span class="nav-item-link"><i class="bi bi-star nav-icon"></i><span class="nav-label">Reviews</span></span></a></li>
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.contacts')) active @else text-white @endif"
                    href="{{ route('app.contacts') }}"><span class="nav-item-link"><i class="bi bi-envelope nav-icon"></i><span class="nav-label">Contacts</span></span></a></li>
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.users')) active @else text-white @endif"
                    href="{{ route('app.users') }}"><span class="nav-item-link"><i class="bi bi-people nav-icon"></i><span class="nav-label">Users</span></span></a></li>
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.profile')) active @else text-white @endif"
                    href="{{ route('app.profile') }}"><span class="nav-item-link"><i class="bi bi-person-circle nav-icon"></i><span class="nav-label">Profile</span></span></a></li>
            <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.settings')) active @else text-white @endif"
                    href="{{ route('app.settings') }}"><span class="nav-item-link"><i class="bi bi-gear nav-icon"></i><span class="nav-label">Settings</span></span></a></li>
        </ul>
    </aside>

    <div class="admin-content">
        <header class="admin-header bg-white border-bottom px-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="h5 mb-0">{{ $heading ?? 'Admin' }}</h1>
            </div>

            <div class="dropdown">
                <button class="btn btn-light border rounded-pill d-flex align-items-center gap-2" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->name ?? 'Admin') }}&background=0D6EFD&color=fff"
                        alt="avatar" style="width: 30px; height: 30px; border-radius: 999px;">
                    <i class="bi bi-chevron-down small"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <h6 class="dropdown-header">{{ auth()->user()?->name ?? 'User' }}</h6>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('app.profile') }}"><i
                                class="bi bi-person me-2"></i>Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i
                                    class="bi bi-box-arrow-right me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <main class="admin-main">
            {{ $slot }}
        </main>

        <footer class="admin-footer bg-white border-top px-4 d-flex align-items-center justify-content-between">
            <small class="text-muted">FrozenBytes Admin Panel</small>
            <small class="text-muted">{{ now()->year }}</small>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function() {
            const shell = document.getElementById('adminShell');
            const toggle = document.getElementById('sidebarToggle');

            toggle?.addEventListener('click', function() {
                if (window.innerWidth <= 991.98) {
                    shell.classList.toggle('sidebar-open');
                    return;
                }
                shell.classList.toggle('sidebar-collapsed');
            });
        })();
    </script>
    @livewireScripts
</body>

</html>
