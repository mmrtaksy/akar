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
                <span data-i18n="services_page.title_prefix">Dijital Dünyada</span>
                <span class="highlight" data-i18n="services_page.title_highlight">Fark Yaratın</span>
            </h1>
            <p class="hero-description" style="max-width: 700px; margin: 0 auto;" data-i18n="services_page.description">
                Markanızın ihtiyaç duyduğu tüm dijital çözümleri tek bir çatı altında sunuyoruz.
            </p>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="section services">
        <div class="container">
            <div class="grid grid-cols-3">
                <!-- Service 1 - Meta & Google Ads -->


                @foreach ($data as $item)
                    <div class="card scroll-animate">
                        <div class="card-icon">
                            <svg width="32" height="32" fill="#2563eb" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="card-title">{{ $item->title }}
                        </h3>
                        <p class="card-description" data-i18n="services.service_1_desc">
                            {{ Helper::turkishcharacters(strip_tags($item->description)) }}
                        </p>
                    </div>
                @endforeach




            </div>
        </div>
    </section>

    <!-- CTA Section -->
   
    @include('includes.cta')
@endsection
