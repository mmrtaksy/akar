{{-- @if (request()->route()->getName() != 'homepage')
<div class="header-span"></div>
@endif --}}

@php
    $rooms = Helper::getMenus('services', 2);
@endphp






@auth
    <a href="{{ route('xloginGet') }}"
        style="font-family:arial; padding: 0.5rem 1rem; background-color: #dc2626; color: white; position: fixed; right: 0; top: 0; z-index: 99999; text-decoration: none;"
        onmouseover="this.style.backgroundColor='#b91c1c'; this.style.color='white';"
        onmouseout="this.style.backgroundColor='#dc2626'; this.style.color='white';">
        Admin
    </a>
@endauth






    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="loading-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="{{ env('APP_BRAND') }} Logo">
        </div>
        <div class="loading-text">AKAR DIGITAL</div>
        <div class="loading-spinner"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <!-- Logo with Cinematic Animation -->
                <a href="@localizedRoute('homepage')" class="logo logo-cinematic">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="{{ env('APP_BRAND') }} logo" width="32" height="32"
                        style="border-radius: 50%; object-fit: cover;">
                    <span>AKAR DIGITAL</span>
                </a>

                <!-- Desktop Navigation -->
                <ul class="nav-menu">
                    <li><a href="@localizedRoute('homepage')" class="nav-link active" data-i18n="nav.home">Ana Sayfa</a></li>
                    <li><a href="@localizedRoute('services')" class="nav-link" data-i18n="nav.services">Hizmetler</a></li>
                    <li><a href="@localizedRoute('about')" class="nav-link" data-i18n="nav.about">Neden Biz</a></li>
                    <li><a href="@localizedRoute('team')" class="nav-link" data-i18n="nav.team">Ekibimiz</a></li>
                    <li><a href="@localizedRoute('contact')" class="nav-link" data-i18n="nav.contact">İletişim</a></li>
                </ul>

                <!-- Nav Actions -->
                <div class="nav-actions">
                    <!-- Dark Mode Toggle -->
                    <button class="icon-btn" id="darkModeToggle" onclick="toggleDarkMode()" title="Tema Değiştir">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    <!-- Mobile Menu Button -->
                    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>
                </div>
            </nav>
        </div>
    </header>






    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <button class="mobile-menu-btn" onclick="closeMobileMenu()"
            style="position: absolute; top: 20px; right: 20px; font-size: 32px;">×</button>
        <ul class="nav-menu">
            <li><a href="@localizedRoute('homepage')" class="nav-link active" onclick="closeMobileMenu()">Ana
                    Sayfa</a>
            </li>
            <li><a href="@localizedRoute('services')" class="nav-link"
                    onclick="closeMobileMenu()">Hizmetler</a></li>
            </li>
            <li><a href="@localizedRoute('about')" class="nav-link" onclick="closeMobileMenu()">Neden Biz</a>
            <li><a href="@localizedRoute('team')" class="nav-link" onclick="closeMobileMenu()">Ekibimiz</a></li>
            </li>
            <li><a href="@localizedRoute('contact')" class="nav-link" onclick="closeMobileMenu()">İletişim</a>
            </li>
        </ul>
    </div>

 