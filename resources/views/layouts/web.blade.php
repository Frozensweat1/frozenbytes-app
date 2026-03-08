<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'FrozenBytes' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @livewireStyles
</head>

<body class="bg-light">
    @php
        $siteSetting = \App\Models\SiteSetting::current();
        $logoSrc = $siteSetting->logoAssetUrl();
        $backgroundOne = $siteSetting->backgroundOneAssetUrl();
        $backgroundTwo = $siteSetting->backgroundTwoAssetUrl();
        $pageBackground = $backgroundOne ?: $backgroundTwo;
    @endphp

    <nav class="navbar navbar-expand-lg bg-white border-bottom fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ route('web.home') }}">
                @if ($logoSrc)
                    <img src="{{ $logoSrc }}" alt="logo" style="height: 32px; width: auto;">
                @endif
                <span>{{ $siteSetting->business_name }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('web.home')) active @endif"
                            href="{{ route('web.home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('web.about')) active @endif"
                            href="{{ route('web.about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('web.services')) active @endif"
                            href="{{ route('web.services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('web.projects')) active @endif"
                            href="{{ route('web.projects') }}">Projects</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('web.blog')) active @endif"
                            href="{{ route('web.blog') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('web.contact')) active @endif"
                            href="{{ route('web.contact') }}">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('web.reviews')) active @endif"
                            href="{{ route('web.reviews') }}">Reviews & Ratings</a></li>
                    @guest
                        <li class="nav-item"><a class="nav-link @if (request()->routeIs('login')) active @endif"
                                href="{{ route('login') }}">Login</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link @if (request()->routeIs('app.*')) active @endif"
                                href="{{ route('app.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-decoration-none">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5 mb-5" style="padding-top: 5.8rem; padding-bottom: 12rem;">
        {{ $slot }}
    </main>

    <footer class="bg-dark text-white py-3 fixed-bottom"
        @if ($backgroundTwo) style="background: linear-gradient(rgba(0,0,0,.78), rgba(0,0,0,.88)), url('{{ $backgroundTwo }}') center/cover no-repeat;" @endif>
        <div class="container">
            <div class="d-flex justify-content-between flex-wrap gap-3 align-items-center mb-2">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <small class="fw-semibold">{{ $siteSetting->business_name }}</small>
                    <a class="text-white text-decoration-none small" href="{{ route('web.home') }}">Home</a>
                    <a class="text-white text-decoration-none small" href="{{ route('web.about') }}">About</a>
                    <a class="text-white text-decoration-none small" href="{{ route('web.services') }}">Services</a>
                    <a class="text-white text-decoration-none small" href="{{ route('web.projects') }}">Projects</a>
                    <a class="text-white text-decoration-none small" href="{{ route('web.blog') }}">Blog</a>
                    <a class="text-white text-decoration-none small" href="{{ route('web.contact') }}">Contact</a>
                    <a class="text-white text-decoration-none small" href="{{ route('web.reviews') }}">Reviews</a>
                </div>
                <div class="d-flex align-items-center gap-3">
                    @if ($siteSetting->facebook_url)
                        <a class="text-white" href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener"
                            aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if ($siteSetting->instagram_url)
                        <a class="text-white" href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener"
                            aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if ($siteSetting->linkedin_url)
                        <a class="text-white" href="{{ $siteSetting->linkedin_url }}" target="_blank" rel="noopener"
                            aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    @endif
                    @if ($siteSetting->youtube_url)
                        <a class="text-white" href="{{ $siteSetting->youtube_url }}" target="_blank" rel="noopener"
                            aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    @endif
                    @if ($siteSetting->tiktok_url)
                        <a class="text-white" href="{{ $siteSetting->tiktok_url }}" target="_blank" rel="noopener"
                            aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    @endif
                    @if ($siteSetting->gmail_url)
                        <a class="text-white" href="{{ $siteSetting->gmail_url }}" target="_blank" rel="noopener"
                            aria-label="Gmail"><i class="bi bi-envelope-at"></i></a>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap gap-2">
                <small>
                    @if ($siteSetting->address)
                        <i class="bi bi-geo-alt me-1"></i>{{ $siteSetting->address }}
                    @endif
                </small>
                <small>{{ now()->year }} {{ $siteSetting->footer_text ?: 'All rights reserved.' }}</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
</body>

</html>
