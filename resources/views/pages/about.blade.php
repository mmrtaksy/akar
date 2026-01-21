@extends('layouts.default', (array) $metaData)

@push('styles')
    <style>
        .wrapper_content * {
            margin: revert;
            font-family: revert;
            font-size: revert;
            list-style: revert;
            padding: revert;
            word-break: initial;
            word-spacing: normal;
            word-wrap: break-word;
        }
    </style>
@endpush
@section('content')


 

    <!-- Page Header -->
    <section class="hero" style="padding: 6rem 0;">
        <div class="container text-center">

            <h1 class="hero-title" style="margin-bottom: 1rem;">
                <span data-i18n="about.title">Biz Kimiz?</span>
            </h1>
            <p class="hero-description" style="max-width: 700px; margin: 0 auto;" data-i18n="about.description">
                Dijital dönüşüm yolculuğunuzda size rehberlik eden tutkulu bir ekibiz.
            </p>
        </div>
    </section>

    <!-- Why Us Section (Moved from Home) -->
    <section class="section" style="background-color: var(--bg-tertiary);">
        <div class="container">
            <div class="text-center" style="margin-bottom: 3rem;">

                <h2 class="section-title" data-i18n="home.why_us_title">Sizi Bir Adım Öne Taşıyoruz</h2>
            </div>

            <div class="grid grid-cols-3 whyus">
                <!-- Card 1 - Yüksek Performans -->
                <div class="card scroll-animate">
                    <div class="card-icon">
                        <div style="font-size: 32px;">⚡</div>
                    </div>
                    <h3 class="card-title" data-i18n="home.why_us_1_title">Yüksek Performans</h3>
                    <p class="card-description" data-i18n="home.why_us_1_desc">Sadece çalışan değil, uçan sistemler
                        yapıyoruz. Hız, SEO ve kullanıcı deneyimi için kritik.</p>
                </div>

                <!-- Card 2 - Güven & Süreklilik -->
                <div class="card scroll-animate">
                    <div class="card-icon">
                        <div style="font-size: 32px;">🛡️</div>
                    </div>
                    <h3 class="card-title" data-i18n="home.why_us_2_title">Güvenlik & Stabilite</h3>
                    <p class="card-description" data-i18n="home.why_us_2_desc">Proje leriniz en güncel güvenlik
                        standartlarıyla korunur, kesintisiz hizmet sunar.</p>
                </div>

                <!-- Card 3 - Kullanıcı Odaklı -->
                <div class="card scroll-animate">
                    <div class="card-icon">
                        <div style="font-size: 32px;">🎯</div>
                    </div>
                    <h3 class="card-title" data-i18n="home.why_us_3_title">Kullanıcı Odaklı</h3>
                    <p class="card-description" data-i18n="home.why_us_3_desc">Tasarım kararlarımızı veriye ve kullanıcı
                        davranışlarına dayalı olarak alıyoruz.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @include('includes.cta')


@endsection