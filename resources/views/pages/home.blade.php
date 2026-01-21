@extends('layouts.default', ['title' => '', 'image' => null])
@section('content')



    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content" style="display: flex; justify-content: center; text-align: center;">
                <div
                    style="width: 100%; max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; align-items: center;">
                    <!-- Badge -->
                    <span class="hero-badge animate-fadeIn">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                clip-rule="evenodd" />
                        </svg>
                        <span data-i18n="hero.badge">Dijital Dönüşümün Lideri</span>
                    </span>

                    <!-- Title - YENİ -->
                    <h1 class="hero-title animate-fadeIn delay-100" data-i18n="hero.title">
                        Dijitalde Sadece Görünür Değil, Rakiplerinizden Bir Adım Önde Olun.
                    </h1>

                    <!-- Description - YENİ -->
                    <p class="hero-description animate-fadeIn delay-200" data-i18n="hero.description"
                        style="margin: 1.5rem auto;">
                        Akar Digital olarak markalara sadece reklam değil, büyüme sistemi kuruyoruz. Meta ve Google
                        Ads'in gücünü profesyonel prodüksiyon, web tasarım ve e-ticaret çözümleriyle birleştirerek
                        işletmenizi dijitalde zirveye taşıyoruz.
                    </p>

                    <!-- CTA Button - YENİ -->
                    <div class="hero-buttons animate-fadeIn delay-300" style="justify-content: center;">
                        <button onclick="scrollToContact()" class="btn btn-primary btn-large">
                            <span data-i18n="hero.cta">👉 Teklif Al</span>
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="hero-stats animate-fadeIn delay-400" style="justify-content: center;">
                        <div class="stat-item">
                            <div class="stat-number">200+</div>
                            <div class="stat-label" data-i18n="hero.stats_projects">Tamamlanan Proje</div>
                        </div>
                        <div style="width: 2px; height: 50px; background-color: var(--border-color);"></div>
                        <div class="stat-item">
                            <div class="stat-number">%98</div>
                            <div class="stat-label" data-i18n="hero.stats_satisfaction">Müşteri Memnuniyeti</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
  
    @include('includes.cta')

 
@endsection